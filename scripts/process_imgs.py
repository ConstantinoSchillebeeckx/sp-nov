#!/usr/bin/env python
"""
description:

    Script will process a directory of images by running OCR on them
    and then labeling the image as either 'specimen' or 'label'.

    Once images are labelled, the PHP script XXX is called which
    will add each Specimen (both the 'specimen' and the 'label')
    as a custom post type to the WP database.


"""

# IMPORTS
import sys, os, argparse, traceback
from os.path import isfile, join
import pandas as pd
import numpy as np
import re, json




# get the number of chars in the OCR results
# does not count spaces or underscores
# input: OCR output content as string
def get_chars(dat, ignore_char):
    tmp = re.sub(ignore_char, '', dat)

    return len(tmp.replace('\n', '').replace(' ',''))


# get the number of lines from the OCR results
# does not count lines that are empty or only
# have underscores
# input: OCR output content as string
def get_lines(dat, ignore_char):
    tmp = re.sub(ignore_char, '', dat)
    
    return len([l for l in tmp.split('\n') if l != ''])


# get the box dimensions of the OCR results
# input: ORF file name
# output: (left, top, width, height) 
# [in average values over all recognized chars]
def get_OCR_box(file, ignore_char):

    left = []
    top = []
    width = []
    height = []
    
    black_list = set(['#','source','block','line','blocks','lines']) # ignore lines with these words
    
    with open(file,'r') as f_in:
        
        for l in f_in.read().split('\n'):
            if l != '' and not len(black_list & set(l.split(' '))):
                tmp = l.split(';')
                dim = tmp[0]
                text = tmp[1]
                
                if len(re.sub(ignore_char, '', text)): # ignore all lines that don't have recognized text
                    dims = [int(l) for l in dim.split(' ') if l != '']
                    left.append(dims[0])
                    top.append(dims[1])
                    width.append(dims[2])
                    height.append(dims[3])
                    
    if len(left):
        return [np.min(left), np.min(top), np.max(width), np.max(height)]
    else:
        return [0,0,0,0]


# converts all imgs to pgm and run ocrad OCR on them
# will return a dict of os.system status for each img
# requires array of img locations
def run_OCR(imgs):

    status = dict()
    for img in imgs:
        break
        name = img.replace('.JPG','') # base name of img
        stat1 = os.system('mogrify -format pgm %s' %img) # convert JPG to BMP
        stat2 = os.system('ocrad -x %s.orf -o %s.txt --filter letters_only --filter upper_num_only --charset ascii %s.pgm' %(name, name, name))
        status[img] = (stat1, stat2)

    return status




# takes list of imgs which have had OCR run on them
# and generates a DF with features for each img
# as well as its type: specimen/label
# requires array of img locations
# NOTE: type can be either 'specimen' (img of actual specimen)
# or 'label' (img of the actual label)
def build_DF(imgs, path, ignore_char):

    # convert data to DF
    dat = pd.DataFrame(index=imgs).sort_index()

    dat['specimen'] = np.nan
    dat['chars'] = np.nan
    dat['lines'] = np.nan
    dat['OCR_left'] = np.nan
    dat['OCR_top'] = np.nan
    dat['OCR_width'] = np.nan
    dat['OCR_height'] = np.nan

    # go through each OCR txt file and count how many characters were found
    txt = sorted([path + f for f in os.listdir(path) if isfile(join(path, f)) and 'txt' in f])
    ocr = {}
    for file in txt:
        with open(file, 'r') as f_in:
            tmp = f_in.read()

            dat.loc[file.replace('txt','JPG'), 'chars'] = get_chars(tmp, ignore_char)
            dat.loc[file.replace('txt','JPG'), 'lines'] = get_lines(tmp, ignore_char)
            
            box = get_OCR_box(file.replace('txt','orf'), ignore_char)
            dat.loc[file.replace('txt','JPG'), 'OCR_left'] = box[0]
            dat.loc[file.replace('txt','JPG'), 'OCR_top'] = box[1]
            dat.loc[file.replace('txt','JPG'), 'OCR_width'] = box[2]
            dat.loc[file.replace('txt','JPG'), 'OCR_height'] = box[3]

    dat['ratio'] = dat.chars / dat.lines
    dat['ratio2'] = dat.chars / dat.OCR_width
    dat['ratio3'] = dat.chars / dat.OCR_height
         
    dat['type'] = 'unknown'

    # assign specimen type
    dat.loc[(dat.chars <= 10) & (dat.type == 'unknown'),'type'] = 'specimen'
    dat.loc[(dat.ratio < 2) & (dat.type == 'unknown'),'type'] = 'specimen'
    dat.loc[(dat.OCR_left > 2000) & (dat.type == 'unknown'),'type'] = 'specimen'

    # assign label type
    dat.loc[(dat.chars > 50) & (dat.type == 'unknown'),'type'] = 'label'
    dat.loc[(dat.type == 'unknown'),'type'] = 'label' # all remaining assumed label

    dat = assign_specimen_number(dat)

    return check_specimen_pairs(dat)


# given the output of build_DF, function will
# assign specimen numbers by incrementing each time
# a new 'label' type is found
# returns the same input with filled out 'specimen' column
def assign_specimen_number(dat):
    specimen = 1
    for i, j in dat.iterrows():
        dat.loc[i,'specimen'] = specimen
        if j['type'] == 'label':
            specimen += 1
            
    return dat




# given the output of assign_specimen_number
# this will check that each specimen number
# has at a minimum a 'specimen' and a 'label'
# if not, its type is switched
# returns the same input after updating 
# specimen number assignment
def check_specimen_pairs(dat):
    for i,j in dat.groupby('specimen'):
        if j.shape[0] == 1: # if specimen number isn't found as at least a pair, switch its type
            if j.type.any() == 'label':
                dat.loc[j.index,'type'] = 'specimen'
            else:
                dat.loc[j.index,'type'] = 'label'

    return assign_specimen_number(dat)



# write output to json file in format
# {specimen_number: [array of images associated with specimen]}
def write_output_json(dat, out='result.json'):
    convert = dict()
    for i,j in dat.groupby('specimen'):
        convert[i] = [l.split('/')[-1].replace('JPG','jpg') for l in j.index.tolist()] # store just img name

    print 'File written to', out
    with open(out, 'w') as fp:
        json.dump(convert, fp)
    




import argparse
class SmartFormatter(argparse.HelpFormatter):
    """
    smart option parser, will extend the help string with the values
    for type e.g. {stype: str} and default (default: None)

    adapted from https://bitbucket.org/ruamel/std.argparse/src/cd5e8c944c5793fa9fa16c3af0080ea31f2c6710/__init__.py?fileviewer=file-view-default
    """

    def __init__(self, *args, **kw):
        self._add_defaults = None
        super(SmartFormatter, self).__init__(*args, **kw)

    def _fill_text(self, text, width, indent):
        return ''.join([indent + line for line in text.splitlines(True)])

    def _split_lines(self, text, width):
        self._add_defaults = True
        text = text
        return argparse.HelpFormatter._split_lines(self, text, width)

    def _get_help_string(self, action):
        help = action.help
        if action.default is not argparse.SUPPRESS:
            defaulting_nargs = [argparse.OPTIONAL, argparse.ZERO_OR_MORE]
            if action.option_strings or action.nargs in defaulting_nargs:
                help += ' {type: %(type)s} (default: %(default)s)'
        return help
# SMARTFORMATTER


# ------------------------------------------------------------------------------------------------------------#
# ------------------------------------------------- MAIN -----------------------------------------------------#
# ------------------------------------------------------------------------------------------------------------#
def main (args):


    ignore_char = r'[_IJTOZLl0-9,\'     ]' # characters to ignore in OCR results
    path = args.path

    # GET LIST OF IMGS
    imgs = sorted([path + f for f in os.listdir(path) if isfile(join(path, f)) and 'JPG' in f])
    print 'Processing %s images in %s' %(len(imgs), path)

    # OCR
    status = run_OCR(imgs)


    # BUILD DF
    dat = build_DF(imgs, path, ignore_char)


    # OUTPUT
    write_output_json(dat)





# SETUP OPTION PARSER
if __name__ == '__main__':
    try:
        parser = argparse.ArgumentParser(description=__doc__,
                            formatter_class=SmartFormatter)
        parser.add_argument("path", type=str,
                            help="Path to imgs to process")
        args = parser.parse_args()
        main(args)
    except KeyboardInterrupt, e: # Ctrl-C
        raise e
    except SystemExit, e: # sys.exit()
        raise e
    except Exception, e:
        print 'ERROR, UNEXPECTED EXCEPTION'
        print str(e)
        traceback.print_exc()
        os._exit(1)

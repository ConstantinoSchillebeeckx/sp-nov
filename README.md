# sp-nov

Simple web-app for adding label metadata to a herbarium specimen.

## Pipeline

1. Export images as JPGs @ 50% quality (sRGB) - ensure labels are properly oriented
2. Upload images through FTP to the server
3. Use media plugin to add images to Media
4. Categorize images by use of python script (this generates a .json)
5. [Upload .json](http://spnov.com/upload/) file which will generate custom post type (Specimen) for each specimen
6. [Classify](http://spnov.com/classify/) to update each specimen's data

## Transfer to tropicos

TODO


## Specimen class

A custom post type for specimen (named Specimen) is used to store data.  It can be considered a class with the following attributes (shown are the key values of the WP database):
- inputGenus
- inputSection
- inputSpecies
- inputCollector
- inputNumber
- inputDeterminer
- inputHerbarium
- inputCountry
- inputDepartment
- inputMunicipality
- inputLocation (location information)
- imgs (array of images associated with specimen)
- finished (0 for unfinished, 1 for finished)
- inputIssue (string for issue associated with specimen, e.g. not enough images)
- history (assoc array with timestamp as key and user id as value)
- status (either 'finished' or 'unfinished')

## User roles

Subscriber
- can view only non-issue specimens
- read only access to data

Contributor
- can view all specimens
- has access to 'View' dropdown
- can edit all data except for 'imgs' meta key

Author
- same priviledges as Contributor but can upload images

Administrator
- like Author but with added priveledge of editing the 'imgs' key


## Notes:
- a specimen is considered 'finished' if the specimen has data for both Collector and Number; in this case, the key 'status' will be set to 'finished'
- by default, any newly added specimen will have the status 'unfinished'
- an internal wordpress only ID is associated with each uploaded specimen; this ID is independent of the number associated with the specimen (that which is defined on the label)

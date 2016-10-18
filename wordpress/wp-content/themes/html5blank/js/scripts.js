var currentID = 0; // global!


/* Get the current values stored in the form

Returns js obj with input name as key and
value as value.  If field nameas are empty
blank strings will be sent in place; this is
required so that data can be deleted when
setting it to blank

*/
function getFormDat() {

    var tmp = jQuery("form").find("[name!='inputView']").serializeArray(); // ignore the view dropdown

    var dat = {};
    for (var i = 0; i < tmp.length; i++) {
        var key = tmp[i].name;
        var val = tmp[i].value;
        dat[key] = val;
    }

    return dat;

}








/* Navigate to next specimen and grab data

Will validate the form and if valide, pull
up that data for the next specimen.  If at
the last specimen, will wrap around

*/
function nextSpecimen() {

    event.preventDefault();
    jQuery('#submit_handle').click(); // needed to validate form

    if (jQuery('form')[0].checkValidity()) { // if valid, load
        loadSpecimen(currentID, 'next', getFormDat());
    }
}

/* Like nextSpecimen() but in other direction

*/
function prevSpecimen() {

    event.preventDefault();
    jQuery('#submit_handle').click(); // needed to validate form

    if (jQuery('form')[0].checkValidity()) { // if valid, load
        loadSpecimen(currentID, 'previous', getFormDat());
    }
}

/* Navigate to next specimen

Just like nextSpecimen() but ignores what specimen user is
currently on.  In this way, there won't be wrapping to next
ID errors.


*/
function viewChange() {

    event.preventDefault();
    jQuery('#submit_handle').click(); // needed to validate form

    if (jQuery('form')[0].checkValidity()) { // if valid, load
        loadSpecimen(null, 'next', getFormDat());
    }
}




/* 

fill the "Label" page with the images and
data for the specified specimen ID

Parameters:
-----------
- id : int
       WP ID for specimen to load, if none provided or ID is 0
       the first specimen will be loaded
- nav: str
       if 'current': the given ID will be loaded [default]
       if 'next': the next chronological ID will be loaded
       if 'previous': the previous ID will be loaded
- dat : obj
        data to be sent to server which represents the data
        for the current specimen.  any data here will be set
        for the specimen
*/
function loadSpecimen(id = 0, nav = 'current', dat) {


    // id 0 will call the first specimen
    if (id == null) id = 0;

    if (nav == null) nav = 'current';


    var data = {
            "action": "loadSpecimen", 
            "id": id, // var set by build_table() in EL.php
            "nav": nav,
            "dat": dat,
    }

    // send data to server
    doAJAX(data);

}




/* Send AJAX request to sever

Will send an AJAX request to the server and properly show/log
the response as either a message to the user or an error
message in the console.

Requests are used to send updated specimen data to the DB as
well as requesting the next/previous specimen along with the
data for that specimen.

Paramters:
----------
- data : obj
         data object to send to the server, must include the
         key 'action' and should include 'id' and 'nav'

*/
function doAJAX(data) {

    console.log(data);

    // we've captured the form data, so now we need to reset it
    // since the page doesn't reload
    jQuery('h1').html('<i class="fa fa-spinner fa-spin fa-fw"></i> loading...');
    jQuery('.img-container').attr('style','display: none;'); // hide 
    jQuery("input[type=text]").val(""); 
    jQuery("input[type=number]").val(""); 
    jQuery("select[name='inputIssue']").val(jQuery("select[name='inputIssue'] option:first").val()); // reset dropdown
    jQuery('.label').remove();
    jQuery('.well').html('');

    // send via AJAX to process with PHP
    jQuery.ajax({
            url: ajax_object.ajax_url, 
            type: "GET",
            data: data, 
            dataType: 'json',
            success: function(response) {

                if (response && response.id) { // response will be false if specimen ID doesn't exist

                    console.log(response);

                    var imgs = response.imgs.split(',');
                    currentID = response.id; // update global

                    // update title
                    if (response.inputNumber) {
                        jQuery('h1').html('Specimen #' + response.inputNumber + ' '); 
                    } else {
                        jQuery('h1').html('Specimen '); 
                    }

                    if (response.inputIssue) {
                        jQuery('.icon').append('<span class="label label-warning">Issue</span>')
                    }
                    if (response.status == 'finished') {
                        jQuery('.icon').html('<span class="label label-success">Labeled</span>')
                    }
                    if (response.downloaded) {
                        jQuery('.icon').append('<span class="label label-info">Downloaded</span>')
                    }


                    jQuery('.well').html('<small>Click a thumbnail to see a larger version.</small><br>'); // clear contents
                    window.history.pushState(currentID, 'Title', '?id=' + currentID); // update URL so things can be bookmarked

                    // generate thumbnails of IMGS
                    for (var i = 0; i < imgs.length; i++) {
                        var src = 'http://' + window.location.host + '/wordpress/wp-content/uploads/' + imgs[i].replace('JPG','jpg');
                        var src_thumb = 'http://' + window.location.host + '/wordpress/wp-content/uploads/' + imgs[i].replace('JPG','jpg').replace('.jpg','-150x150.jpg');
                        jQuery('.well').append('<a href="#" onclick="loadIMG(\'' + src + '\');return false;"><img src="' + src_thumb + '" style="margin:10 10 10 10;"></a>');
                    }

                    // fill inputs
                    jQuery.each(response, function(name, val) {
                        if (name != 'status') {
                            var el = jQuery('[name="'+name+'"]');
                            var type = el.attr('type');
                            el.val(val);
                        }
                    })

                    notes = response.issueNotes; // global!
                    onChangeIssue(); // in case specimen has defined issue

                } else {
                    jQuery('h1').html('Specimen');
                    jQuery('.well').html('<span class="lead">No data available</span>');
                    console.log(response);
                }

            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            },
    });
}


/* onclick handler for thumbnail

Function called each time user clicks on image
thumbnail; will load full sized image into div
placed below the well

*/

function loadIMG(src) {
    jQuery('.img-container').attr('style',''); // previously hidden
    jQuery('.img-container').html('<img src="' + src + '" />');
}







/* Download images of specimens in results as zip

Provided a search has been made (and the global
searchResults var is set) function will generate
a zip filled with the images of the search
results and will generate a download link for the
user.

Parameters:
-----------
- rename: bool
          if true, images will be renamed per the BoGart
          guidelines before being put in zip

Returns:
--------
beforeSend - will show loading text
success - will generate a href with download link
error - will show error message
*/
function downloadSpecimens(rename) {


    if (searchResults.length) { // require search results before anything can be downloaded

        var data = {
            "action": "downloadSpecimens", 
            "rename": rename,
            "ids": searchResults,
            "onlyNotDownloaded": false,
        }

        // send via AJAX to process with PHP
        jQuery.ajax({
            url: ajax_object.ajax_url, 
            type: "GET",
            data: data, 
            dataType: 'json',
            beforeSend: function() {
                jQuery('#searchResults').empty(); // clear search results
                jQuery('#searchResults').append('<p class="lead"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>Generating download file...</p>')
            },
            success: function(response) {
                console.log(response)
                if (response.success) {
                    jQuery('#searchResults').append('<a href="' + response.url + '" style="text-decoration:none" class="btn btn-info"><i class="fa fa-download" aria-hidden="true"></i> Download images</a>');
                } else {
                    jQuery('#searchResults').append(response.msg);
                }
            },
            error: function(error) { console.log(error) }
        });
    } else {
        jQuery('#searchResults').empty(); // clear search results
        jQuery('#searchResults').append('<p class="lead">You must first run a search to download any specimens.<br><b>NOTE:</b> only those specimens listed in the search results will be downloaded.</p>');
    }

}




/* Called from search page, used to query specimens that match query

AJAX call to query the DB for specimens that meet user
defined criteria.  Will send "rules" and get back a 
list of specimens that match those rules 

Parameters:
-----------
assumes the var builderOptions.filters exists
(which is defined in js/formInputs.js) as well
as the 'rules' from the query builder form

Returns:
--------
response.dat is an object where each key is
a specimen, the value is an obj with key/val
pairs for its associated data. will be false
if no results are returned


*/
function searchSpecimen() {

    var rules = jQuery('#builder').queryBuilder('getSQL', 'question_mark');
    var validSearch = jQuery('#builder').queryBuilder('validate'); // true if no error in query search

    var colMap = {};
    builderOptions.filters.forEach( function(d) { colMap[d.field] = d.label; } )

    // manually add history field to search output
    colMap['history'] = 'Last edit';

    var data = {
        "action": "findSpecimen", 
        "dat": rules,
    }

    console.log(data);

    // send via AJAX to process with PHP
    if (validSearch) {
        jQuery.ajax({
            url: ajax_object.ajax_url, 
            type: "GET",
            data: data, 
            dataType: 'json',
            beforeSend: function() {
                jQuery("button").prop("disabled",true); // disable all buttons
                jQuery('#searchResults').empty(); // clear search results
                jQuery('#searchResults').append('<p class="lead"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i> Loading...</p>'); // add spinner
            },
            success: function(response) {
                console.log(response);
                jQuery("button").prop("disabled",false); // enable all buttons
                jQuery('#searchResults').empty();
                if (response.dat != null) {
                    searchResults = Object.keys(response.dat); // set to global for use with downloadSpecimens()
                    generateSearchResultsTable(response.dat, '#searchResults', colMap);
                } else {
                    jQuery('#searchResults').append('<p class="lead">No results!</p>');
                }
            },
            error: function(error) { console.log(error) }
        });
    }
}




/* Generate HTML table with search results

Parameters:
-----------
- dat : obj
        response.dat is an object where each key is
        a specimen, the value is an obj with key/val
        pairs for its associated data
- sel : str
        selector for DOM into which to put results
- colMap : obj
           key: DB meta_key; value: table col name
*/
function generateSearchResultsTable(dat, sel, colMap) {

    jQuery(sel).empty();

    if (dat) {

        jQuery('<p class="lead"><code>' + Object.keys(dat).length + '</code> specimens found!</p>').appendTo(sel);
        var table = jQuery('<table class="table table-striped table-responsive" style="font-size:10px">').appendTo(sel);
        var thead = jQuery('<thead>').appendTo(table);
        var tbody = jQuery('<tbody>').appendTo(table);


        var theadr = jQuery('<tr class="info"/>');
        jQuery.each(colMap, function(field, label) {
            theadr.append('<td><b>' + label + '</b></td>');
        })
        thead.append(theadr);

        jQuery.each(dat, function(i, row) {
            var tr = jQuery('<tr/>');
            jQuery.each(colMap, function(field, label) {
                var val = row[field]
                if (typeof val !== 'undefined') {
                    if (field == 'status') {
                        val = '<a href="/label_specimen/?id=' + i + '">' + val + '</a>';
                    }
                } else {
                    val = '';
                }
                tr.append('<td>' + val + '</td>');
            })
            tbody.append(tr);
        })

    } else {
        jQuery('<p class="lead">No results found in the database!</p>').appendTo(sel);
    }

}








/* Used to create input form for labeling specimen

Will automatically populate the input form for
classifying/labeling the specimen based
onthe var builderOptions.filters
(which is defined in js/formInputs.js)

*/
function populateForm(data, callback) {


    for (var i=0; i<data.length; i++) {

        var dat = data[i];
        if (!dat.hide) {
            var fg = jQuery('<div class="form-group">').appendTo('#formInputs');

            // add label
            var label = jQuery('<label class="col-sm-3 control-label" data-toggle="popover" data-trigger="hover" >').text(dat.id).appendTo(fg);
            if ('labelTag' in dat) {
                label.attr("title",dat.labelTag.title)
                label.attr("data-content", dat.labelTag["data-content"])
            }

            // add input
            var col = jQuery('<div class="col-sm-9">').appendTo(fg);
            if (dat.type == 'string') {
                if (dat.input == 'select') {
                    var sel = jQuery('<select class="form-control">').appendTo(col);
                    sel.attr("name", dat.field)
                    sel.attr("onchange", dat.onchange)
                    jQuery.each(dat.values, function(k, v) {
                        sel.append(jQuery("<option>").attr('value',k).text(v));
                    });
                } else {
                    var input = jQuery('<input type="text" class="form-control">').appendTo(col);    
                    input.attr('name', dat.field)
                    input.attr('title', dat.title)
                    input.attr('placeholder', dat.placeholder)
                    input.attr('pattern', dat.validation.format)
                }
            } else if (dat.type == 'integer') {
                var input = jQuery('<input type="number" class="form-control">').appendTo(col);    
                input.attr('name', dat.field)
                input.attr('title', dat.title)
                input.attr('placeholder', dat.placeholder)
                input.attr('pattern', dat.validation.format)
            }

            if('extraHTML' in dat) {
                fg.after(dat.extraHTML);
            }
        }
    }

    if (callback) callback();

}



/* Called when issue select is changed and when specimen is loaded

Disable form inputs on classify page. This is done when 
a specimen has a defined issue; will disable all inputs 
except for the "View" and "Issue".

Will also add an "Issue notes" text input box in cases
when the selected issue is "Problematic field" or
"Other issue not listed"

*/
function onChangeIssue() {

    var sel = jQuery( "[name='inputIssue']" ).val();

    if (sel != '') { // if issue is set, set all inputs to read only and show the issueNotes field
        jQuery("input").not("[name='issueNotes']").prop('readonly', true);
        jQuery('[name="issueNotes"]').parent().parent().show();
        jQuery('[name="issueNotes"]').val(notes);  // notes is Global
    } else { // if issue is none, hide the notes section and empty it
        jQuery("input").prop('readonly', false);
        jQuery('[name="issueNotes"]').parent().parent().hide();
        jQuery('[name="issueNotes"]').val(''); // empty input box
    }

}











/*

Provided a search has been made (and the global
searchResults var is set) function will 
generate/download a CSV will all the available data
which can be used to insert into Tropicos.

Called from the download dropdown for "Tropicos CSV"

Parameters:
-----------
- rename: bool
          if true, images will be renamed per the BoGart
          guidelines before being put in zip

Returns:
--------
*/
function downloadTropicosCSV() {

    if (searchResults.length) { // require search results before anything can be downloaded

        var colMap = {}; // {inputGenus: Genus, ...}
        builderOptions.filters.forEach( function(d) { colMap[d.field] = d.label; } )

        var data = {
            "action": "downloadTropicosCSV", 
            "ids": searchResults,
            "colMap": colMap,
        }

        console.log(data);

        // send via AJAX to process with PHP
        jQuery.ajax({
            url: ajax_object.ajax_url, 
            type: "GET",
            data: data, 
            dataType: 'json',
            success: function(response) {

                var dat = response.dat;

                // get array of Obj with col values [{inputGenus: Anthurium, ...},...]
                var data = [];
                for (var id in dat) {
                    data.push(dat[id]);
                }
                var csvContent = "data:text/csv;charset=utf-8," + toCsv(data, colMap);
                var encodedUri = encodeURI(csvContent);
                window.open(encodedUri);
            },
            error: function(error) { console.log(error) }
        });
    } else {
        jQuery('#searchResults').empty(); // clear search results
        jQuery('#searchResults').append('<p class="lead">You must first run a search to download any specimens.<br><b>NOTE:</b> only those specimens listed in the search results will be downloaded.</p>');
    }

}





/**
* Converts a value to a string appropriate for entry into a CSV table.  E.g., a string value will be surrounded by quotes.
* @param {string|number|object} theValue
* @param {string} sDelimiter The string delimiter.  Defaults to a double quote (") if omitted.
*/
function toCsvValue(theValue, sDelimiter) {
    var t = typeof (theValue), output;

    if (typeof (sDelimiter) === "undefined" || sDelimiter === null) {
        sDelimiter = '"';
    }

    if (t === "undefined" || t === null) {
        output = "";
    } else if (t === "string") {
        output = sDelimiter + theValue + sDelimiter;
    } else {
        output = String(theValue);
    }

    return output;
}

/**
* Converts an array of objects (with identical schemas) into a CSV table.
* @param {Array} objArray An array of objects.  Each object in the array must have the same property list.
* @param {string} sDelimiter The string delimiter.  Defaults to a double quote (") if omitted.
* @param {string} cDelimiter The column delimiter.  Defaults to a comma (,) if omitted.
* @return {string} The CSV equivalent of objArray.
*/
function toCsv(objArray, colMap, sDelimiter, cDelimiter) {
    var i, l, names = [], name, value, obj, row, output = "", n, nl;


    // Initialize default parameters.
    if (typeof (sDelimiter) === "undefined" || sDelimiter === null) {
        sDelimiter = '"';
    }
    if (typeof (cDelimiter) === "undefined" || cDelimiter === null) {
        cDelimiter = ",";
    }

    for (i = 0, l = objArray.length; i < l; i += 1) {
        // Get the names of the properties.
        obj = objArray[i];
        row = "";
        if (i === 0) {
            // Loop through the names
            for (name in obj) {
                if (obj.hasOwnProperty(name)) {
                    names.push(name);
                    row += [sDelimiter, colMap[name], sDelimiter, cDelimiter].join("");
                }
            }
            row = row.substring(0, row.length - 1);
            output += row;
        }

        output += "\n";
        row = "";
        for (n = 0, nl = names.length; n < nl; n += 1) {
            name = names[n];
            value = obj[name];
            if (n > 0) {
                row += ","
            }
            row += toCsvValue(value, '"');
        }
        output += row;
    }

    return output;
}



// will run PHP add_media_from_ftp function through AJAX
// will keep refreshing as long as the reponse is a 500 error
function updateMedia() {

        var data = {
            "action": "add_media_from_ftp", 
        }

        // send via AJAX to process with PHP
        jQuery.ajax({
            url: ajax_object.ajax_url, 
            type: "GET",
            data: data, 
            dataType: 'json',
            success: function(response) {
                console.log(response);
            },
            error: function(error) { 
                console.log(error)
                //location.reload(); // keep reloading until no 500 error :(
            }
        });

}

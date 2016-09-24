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





/* 

fill the classify page with the images and
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
- view : str
         specimen status to view, must be one of 'all', 
         'completed','unfinished','issue'
*/
function loadSpecimen(id, nav, dat) {


    // id 0 will call the first specimen
    if (id == null) id = 0;

    if (nav == null) nav = 'current';

    var data = {
            "action": "loadSpecimen", 
            "id": id, // var set by build_table() in EL.php
            "nav": nav,
            "dat": dat,
            "view": jQuery("select[name=inputView]").val(),
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

    // clear things out before doing any AJAX in case connection is slow
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
                        jQuery('.icon').html('<span class="label label-warning">issue</span>')
                    } else if (response.status == 'finished') {
                        jQuery('.icon').html('<span class="label label-success">finished</span>')
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
                        var el = jQuery('[name="'+name+'"]');
                        var type = el.attr('type');
                        el.val(val);
                    })

                } else {
                    jQuery('h1').html('Specimen');
                    jQuery('.well').html('<span class="lead">No data available</span>');
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
pairs for its associated data


*/
function searchSpecimen() {
    var rules = jQuery('#builder').queryBuilder('getRules');
    console.log("sent to server:", rules);

    var cols = [];
    builderOptions.filters.forEach( function(d) { cols.push(d.field); } )

    var data = {
        "action": "findSpecimen", 
        "dat": rules,
        "cols": cols,
    }

    // send via AJAX to process with PHP
    jQuery.ajax({
        url: ajax_object.ajax_url, 
        type: "GET",
        data: data, 
        dataType: 'json',
        success: function(response) {
            console.log("received from server:", response);
            generateSearchResultsTable(response.dat, '#searchResults', cols);
        },
        error: function(error) { console.log(error) }
    });
}




/* Generate HTML table with search results

Parameters:
-----------
- dat : obj
        response.dat is an object where each key is
        a specimen, the value is an obj with key/val
        pairs for its associated data

*/
function generateSearchResultsTable(dat, sel, cols) {

    jQuery('table').remove();

    var table = jQuery('<table class="table table-striped table-responsive" style="font-size:8px">').appendTo(sel);
    var thead = jQuery('<thead>').appendTo(table);
    var tbody = jQuery('<tbody>').appendTo(table);


    var theadr = jQuery('<tr class="info"/>');
    jQuery.each(cols, function(i, col) {
        theadr.append('<td>' + col + '</td>');
    })
    thead.append(theadr);

    jQuery.each(dat, function(i, row) {
        var tr = jQuery('<tr/>');
        jQuery.each(cols, function(j, col) {
            var val = ''
            if (row[col]) {
                val = row[col];
                if (j == 0) {
                    val = '<a href="/classify/?id=' + i + '">' + val + '</a>';
                }
            }
            tr.append('<td>' + val + '</td>');
        })
        tbody.append(tr);
    })

}








/* Used to create input form for labeling specimen

Will automatically populate the input form for
classifying/labeling the specimen based
onthe var builderOptions.filters
(which is defined in js/formInputs.js)

*/
function populateForm(data, callback) {

    console.log(data)

    for (var i=0; i<data.length; i++) {

        var dat = data[i];

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
                sel.attr("name", dat.name)
                sel.attr("onchange", dat.onchange)
                jQuery.each(dat.values, function(k, v) {
                    sel.append(jQuery("<option>").attr('value',k).text(v));
                });
            } else {
                var input = jQuery('<input type="text" class="form-control">').appendTo(col);    
                input.attr('name', dat.field)
                input.attr('title', dat.title)
                input.attr('placeholder', dat.placeholder)
            }
        } else if (dat.type == 'integer') {
            var input = jQuery('<input type="number" class="form-control">').appendTo(col);    
            input.attr('name', dat.field)
            input.attr('title', dat.title)
            input.attr('placeholder', dat.placeholder)
        }

        if('extraHTML' in dat) {
            fg.after(dat.extraHTML);
        }
    }

    if (callback) callback();

}








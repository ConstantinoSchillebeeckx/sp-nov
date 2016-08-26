function nextSpecimen() {

}



function prevSpecimen() {

}


// fill the classify page with the images and
// data for the specified specimen ID
function loadSpecimen(id) {

    if (event) {
        event.preventDefault(); // cancel form submission
    }


    if (id) {

        var data = {
                "action": "loadSpecimen", 
                "id": id, // var set by build_table() in EL.php
        }

        // send data to server
        doAJAX(data);

    }

}




/* Send AJAX request to sever

Will send an AJAX request to the server and properly show/log
the response as either a message to the user or an error
message in the console.

Paramters:
----------
- data : obj
         data object to send to the server, must include the
         key 'action'

*/
function doAJAX(data) {


    // send via AJAX to process with PHP
    jQuery.ajax({
            url: ajax_object.ajax_url, 
            type: "GET",
            data: data, 
            dataType: 'json',
            success: function(response) {

                if (response) { // response will be false if specimen ID doesn't exist
                    var imgs = response.imgs;

                    // generate thumbnails of IMGS
                    for (var i = 0; i < imgs.length; i++) {
                        var src = 'http://' + window.location.host + '/wordpress/wp-content/uploads/' + imgs[i].replace('JPG','jpg');
                        var src_thumb = 'http://' + window.location.host + '/wordpress/wp-content/uploads/' + imgs[i].replace('JPG','jpg').replace('.jpg','-150x150.jpg');
                        jQuery('.well').append('<a href="' + src + '"><img src="' + src_thumb + '" style="margin-left:10px; margin-right:10px;"></a>');
                    }


                    console.log(imgs);
                } else {
                    jQuery('.well').html('<span class="lead">Specimen ID ' + data.id + ' doesn\'t exist in the database!</span>');
                }

            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            },
    });
}

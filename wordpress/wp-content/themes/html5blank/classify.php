<?php /* Template Name: Classify template */ get_header(); ?>

	<main role="main">
		<!-- section -->
		<section>

			<h1><?php the_title(); ?></h1>
            <div class="icon"></div>

            <?php // only show form if a user is logged in
            if ( !is_user_logged_in() ) {
                echo sprintf('<p class="lead login-link">You must <a href="%s">sign in</a> to view this page.</p>', wp_login_url( get_permalink() ) );
                return;
            };
            ?>


			<!-- article -->
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                <div class="row" style="padding-top:10px;">
                    <div class="col-sm-8"> <!-- div for images -->
                        <div class="well text-muted">
                            <!-- content dynamically filled with AJAX -->
                        </div>
                        <div class="col-sm-12 img-container" style="display: none;">
                            <!-- content dynamically filled with function loadIMG() -->
                        </div>
                    </div>
                    
                    <div class="col-sm-4"> <!-- div for form -->
                        <form class="form-horizontal" onsubmit="return false" autocomplete="off">

                            <div id="formInputs"></div> <!-- content dynamically rendered by populateForm() function -->

                            <?php if (in_array('administrator',  wp_get_current_user()->roles)) { // if admin, show IMG input ?>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label" data-toggle="popover" data-trigger="hover" title="Images" data-content="Date on which specimen has been batch downloaded." aria-hidden="true">Downloaded</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="downloaded">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label" data-toggle="popover" data-trigger="hover" title="Images" data-content="Comma-separated (no spaces or quotes) list of filenames for JPG images associated with a specimen.  Example: DSC09272.JPG,DSC09273.JPG" aria-hidden="true">Imgs</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="imgs">
                                    </div>
                                </div>
                            <?php } ?>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <i class="fa fa-chevron-circle-left fa-4x text-primary navSpecimen" aria-hidden="true" onclick="prevSpecimen()"></i>
                                </div>
                                <div class="col-sm-6 text-muted" style="padding: 0;">
                                    <small>Changes saved once either nav button is clicked.</small>
                                </div>
                                <div class="col-sm-3">
                                    <i class="fa fa-chevron-circle-right pull-right fa-4x text-primary navSpecimen" aria-hidden="true" onclick="nextSpecimen()"></i>
                                </div>
                            </div>
                            <input id="submit_handle" type="submit" style="display: none"> <!-- needed for validating form -->
                        </form>
                    </div>
                </div>


			</article>
			<!-- /article -->

            <script>
                jQuery(document).ready(function() {
                    // load first specimen
                    var firstSpecimen = loadSpecimen(<?php echo isset($_GET['id']) ? $_GET['id']: 0;  ?>, null, {"status":"unfinished"});

                    // populate form with inputs
                    // var defined in js/formInputs.js
                    populateForm(builderOptions.filters, firstSpecimen);


                    // autocomplete script
                    var deferRequestBy = 0;
                    jQuery('input[name="inputGenus"]').devbridgeAutocomplete({
                        serviceUrl: ajax_object.ajax_url, 
                        deferRequestBy: deferRequestBy,
                        params:{'action':'autoComplete','key':'inputGenus'}
                    });

                    jQuery('input[name="inputSpecies"]').devbridgeAutocomplete({
                        serviceUrl: ajax_object.ajax_url, 
                        deferRequestBy: deferRequestBy,
                        params:{'action':'autoComplete','key':'inputSpecies'}
                    });

                    jQuery('input[name="inputAuthority"]').devbridgeAutocomplete({
                        serviceUrl: ajax_object.ajax_url, 
                        deferRequestBy: deferRequestBy,
                        params:{'action':'autoComplete','key':'inputAuthority'}
                    });

                    jQuery('input[name="inputCollector"]').devbridgeAutocomplete({
                        serviceUrl: ajax_object.ajax_url, 
                        deferRequestBy: deferRequestBy,
                        params:{'action':'autoComplete','key':'inputCollector'}
                    });

                    jQuery('input[name="inputDeterminer"]').devbridgeAutocomplete({
                        serviceUrl: ajax_object.ajax_url, 
                        deferRequestBy: deferRequestBy,
                        params:{'action':'autoComplete','key':'inputDeterminer'}
                    });

                    jQuery('input[name="inputHerbarium"]').devbridgeAutocomplete({
                        serviceUrl: ajax_object.ajax_url, 
                        deferRequestBy: deferRequestBy,
                        params:{'action':'autoComplete','key':'inputHerbarium'}
                    });

                    jQuery('input[name="inputCountry"]').devbridgeAutocomplete({
                        serviceUrl: ajax_object.ajax_url, 
                        deferRequestBy: deferRequestBy,
                        params:{'action':'autoComplete','key':'inputCountry'}
                    });

                    jQuery('input[name="inputMunicipality"]').devbridgeAutocomplete({
                        serviceUrl: ajax_object.ajax_url, 
                        deferRequestBy: deferRequestBy,
                        params:{'action':'autoComplete','key':'inputMunicipality'}
                    });

                    jQuery('input[name="inputDepartment"]').devbridgeAutocomplete({
                        serviceUrl: ajax_object.ajax_url, 
                        deferRequestBy: deferRequestBy,
                        params:{'action':'autoComplete','key':'inputDepartment'}
                    });


                    jQuery('label').popover({placement:'auto left', container: 'body', html: true})
                });

            </script>

		</section>
		<!-- /section -->
	</main>



<?php get_footer(); ?>

<script>
</script>

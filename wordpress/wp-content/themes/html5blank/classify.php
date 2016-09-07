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
                        <form class="form-horizontal" onsubmit="return false">
                            <div class="form-group">
                                <label class="col-sm-3 control-label" data-toggle="popover" data-trigger="hover" title="Title" data-content="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum feugiat sodales. In hac habitasse platea dictumst. Nunc blandit suscipit finibus. Donec sit amet venenatis tortor. Pellentesque vel posuere nunc." aria-hidden="true">View</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="inputView" onchange="nextSpecimen()">
                                        <option selected value="all">All specimens</option>
                                        <option value="finished">Finished specimens</option>
                                        <option value="unfinished">Unfinished specimens</option>
                                        <option value="issue">Specimen with issue</option>
                                    </select>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" data-toggle="popover" data-trigger="hover" title="Title" data-content="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum feugiat sodales. In hac habitasse platea dictumst. Nunc blandit suscipit finibus. Donec sit amet venenatis tortor. Pellentesque vel posuere nunc." aria-hidden="true">Genus</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="inputGenus" placeholder="Anthurium" pattern="[a-zA-Z]+" title="Only letters are allowed" autofocus>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" data-toggle="popover" data-trigger="hover" title="Title" data-content="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum feugiat sodales. In hac habitasse platea dictumst. Nunc blandit suscipit finibus. Donec sit amet venenatis tortor. Pellentesque vel posuere nunc." aria-hidden="true">Section</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="inputSection" placeholder="Belolonchium" pattern="[a-zA-Z]+" title="Only letters are allowed" autofocus>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" data-toggle="popover" data-trigger="hover" title="Title" data-content="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum feugiat sodales. In hac habitasse platea dictumst. Nunc blandit suscipit finibus. Donec sit amet venenatis tortor. Pellentesque vel posuere nunc." aria-hidden="true">Species</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="inputSpecies" placeholder="longipoda" pattern="[a-zA-Z]+" title="Only letters are allowed">
                                </div>
                            </div>
                            <!-- <div class="form-group">
                                <label class="col-sm-3 control-label" data-toggle="popover" data-trigger="hover" title="Title" data-content="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum feugiat sodales. In hac habitasse platea dictumst. Nunc blandit suscipit finibus. Donec sit amet venenatis tortor. Pellentesque vel posuere nunc." aria-hidden="true">Authority</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="inputAuthor" placeholder="Schott" pattern="[a-zA-Z]+" title="Only letters are allowed">
                                </div>
                            </div>-->
                            <div class="form-group">
                                <label class="col-sm-3 control-label" data-toggle="popover" data-trigger="hover" title="Title" data-content="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum feugiat sodales. In hac habitasse platea dictumst. Nunc blandit suscipit finibus. Donec sit amet venenatis tortor. Pellentesque vel posuere nunc." aria-hidden="true">Collector</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="inputCollector" placeholder="Betancur" pattern="[a-zA-Z ]+" title="Only letters and spaces are allowed">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" data-toggle="popover" data-trigger="hover" title="Title" data-content="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum feugiat sodales. In hac habitasse platea dictumst. Nunc blandit suscipit finibus. Donec sit amet venenatis tortor. Pellentesque vel posuere nunc." aria-hidden="true">Number</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="inputNumber" placeholder="436" pattern="[a-zA-Z0-9]+" title="Only letters and numbers are allowed">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" data-toggle="popover" data-trigger="hover" title="Title" data-content="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum feugiat sodales. In hac habitasse platea dictumst. Nunc blandit suscipit finibus. Donec sit amet venenatis tortor. Pellentesque vel posuere nunc." aria-hidden="true">Determiner</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="inputDeterminer" placeholder="Croat" pattern="[a-zA-Z]+" title="Only letters are allowed">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" data-toggle="popover" data-trigger="hover" title="Title" data-content="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum feugiat sodales. In hac habitasse platea dictumst. Nunc blandit suscipit finibus. Donec sit amet venenatis tortor. Pellentesque vel posuere nunc." aria-hidden="true">Herbarium</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="inputHerbarium" placeholder="COL" pattern="[a-zA-Z]+" title="Only letters are allowed">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" data-toggle="popover" data-trigger="hover" title="Title" data-content="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum feugiat sodales. In hac habitasse platea dictumst. Nunc blandit suscipit finibus. Donec sit amet venenatis tortor. Pellentesque vel posuere nunc." aria-hidden="true">Country</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="inputCountry" placeholder="Colombia" pattern="[a-zA-Z]+" title="Only letters are allowed">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" data-toggle="popover" data-trigger="hover" title="Title" data-content="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum feugiat sodales. In hac habitasse platea dictumst. Nunc blandit suscipit finibus. Donec sit amet venenatis tortor. Pellentesque vel posuere nunc." aria-hidden="true">Dept.</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="inputDepartment" placeholder="Tolima" pattern="[a-zA-Z]+" title="Only letters are allowed">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" data-toggle="popover" data-trigger="hover" title="Title" data-content="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum feugiat sodales. In hac habitasse platea dictumst. Nunc blandit suscipit finibus. Donec sit amet venenatis tortor. Pellentesque vel posuere nunc." aria-hidden="true">Mun.</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="inputMunicipality" placeholder="Icononzo" pattern="[a-zA-Z]+" title="Only letters are allowed">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" data-toggle="popover" data-trigger="hover" title="Title" data-content="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum feugiat sodales. In hac habitasse platea dictumst. Nunc blandit suscipit finibus. Donec sit amet venenatis tortor. Pellentesque vel posuere nunc." aria-hidden="true">Location</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="inputLocation" placeholder="el Taladro finca la Esperanza" pattern="[a-zA-Z0-9 ]+" title="Only letters, spaces and numbers are allowed">
                                </div>
                            </div>
                            <!--<div class="form-group">
                                <label class="col-sm-3 control-label" data-toggle="popover" data-trigger="hover" title="Title" data-content="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum feugiat sodales. In hac habitasse platea dictumst. Nunc blandit suscipit finibus. Donec sit amet venenatis tortor. Pellentesque vel posuere nunc." aria-hidden="true">Lat./Lon.</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="inputLatLon" placeholder="10 59N 74 04W" pattern="[0-9NW\. ]+" title="Only numbers, spaces and the characters 'N', 'W' or '.' are allowed.">
                                </div>
                            </div>-->
                            <div class="form-group">
                                <label class="col-sm-3 control-label" data-toggle="popover" data-trigger="hover" title="Title" data-content="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum feugiat sodales. In hac habitasse platea dictumst. Nunc blandit suscipit finibus. Donec sit amet venenatis tortor. Pellentesque vel posuere nunc." aria-hidden="true">Issue</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="inputIssue">
                                        <option selected value>None</option>
                                        <option value="no_label">No label present</option>
                                        <option value="multiple_specimens">Multiple specimens shown</option>
                                        <option value="problem_label">Problematic label</option>
                                    </select>
                                </div>
                            </div>
                            <?php if (in_array('administrator',  wp_get_current_user()->roles)) { ?>
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
                // load first specimen
                loadSpecimen(<?php echo isset($_GET['id']) ? $_GET['id']: 0;  ?>);
            </script>


            <!-- autocomplete script -->
            <script>
                var deferRequestBy = 75;
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
            </script>

		</section>
		<!-- /section -->
	</main>



<?php get_footer(); ?>

<script>
    jQuery('label').popover({placement:'auto left', container: 'body'})
</script>

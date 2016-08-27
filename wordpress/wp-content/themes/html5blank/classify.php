<?php /* Template Name: Classify template */ get_header(); ?>

	<main role="main">
		<!-- section -->
		<section>

			<h1><?php the_title(); ?></h1>

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
                        <div class="well">
                            <!-- content dynamically filled with AJAX -->
                        </div>
                    </div>
                    
                    <div class="col-sm-4"> <!-- div for form -->
                        <form class="form-horizontal" onsubmit="return false">
                            <div class="form-group">
                                <label class="col-sm-3 control-label" data-toggle="popover" data-trigger="hover" title="Title" data-content="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum feugiat sodales. In hac habitasse platea dictumst. Nunc blandit suscipit finibus. Donec sit amet venenatis tortor. Pellentesque vel posuere nunc." aria-hidden="true">View</label>
                                <label class="radio-inline">
                                    <input type="radio" name="inputView" id="inlineRadio1" value="all"> All
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="inputView" id="inlineRadio2" value="completed"> Completed
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="inputView" id="inlineRadio3" value="unfinished" checked> Unfinished
                                </label>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" data-toggle="popover" data-trigger="hover" title="Title" data-content="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum feugiat sodales. In hac habitasse platea dictumst. Nunc blandit suscipit finibus. Donec sit amet venenatis tortor. Pellentesque vel posuere nunc." aria-hidden="true">Genus</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="inputGenus" placeholder="Anthurium">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" data-toggle="popover" data-trigger="hover" title="Title" data-content="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum feugiat sodales. In hac habitasse platea dictumst. Nunc blandit suscipit finibus. Donec sit amet venenatis tortor. Pellentesque vel posuere nunc." aria-hidden="true">Species</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="inputSpecies" placeholder="longipoda">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" data-toggle="popover" data-trigger="hover" title="Title" data-content="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum feugiat sodales. In hac habitasse platea dictumst. Nunc blandit suscipit finibus. Donec sit amet venenatis tortor. Pellentesque vel posuere nunc." aria-hidden="true">Authority</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="inputAuthor" placeholder="Schott">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" data-toggle="popover" data-trigger="hover" title="Title" data-content="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum feugiat sodales. In hac habitasse platea dictumst. Nunc blandit suscipit finibus. Donec sit amet venenatis tortor. Pellentesque vel posuere nunc." aria-hidden="true">Number</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="inputNumber" placeholder="436">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" data-toggle="popover" data-trigger="hover" title="Title" data-content="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum feugiat sodales. In hac habitasse platea dictumst. Nunc blandit suscipit finibus. Donec sit amet venenatis tortor. Pellentesque vel posuere nunc." aria-hidden="true">Collector</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="inputCollector" placeholder="Betancur">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" data-toggle="popover" data-trigger="hover" title="Title" data-content="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum feugiat sodales. In hac habitasse platea dictumst. Nunc blandit suscipit finibus. Donec sit amet venenatis tortor. Pellentesque vel posuere nunc." aria-hidden="true">Determiner</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="inputDeterminer" placeholder="Croat">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" data-toggle="popover" data-trigger="hover" title="Title" data-content="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum feugiat sodales. In hac habitasse platea dictumst. Nunc blandit suscipit finibus. Donec sit amet venenatis tortor. Pellentesque vel posuere nunc." aria-hidden="true">Herbarium</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="inputHerbarium" placeholder="COL">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" data-toggle="popover" data-trigger="hover" title="Title" data-content="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum feugiat sodales. In hac habitasse platea dictumst. Nunc blandit suscipit finibus. Donec sit amet venenatis tortor. Pellentesque vel posuere nunc." aria-hidden="true">Location</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="inputLocation" placeholder="el Taladro finca la Esperanza">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" data-toggle="popover" data-trigger="hover" title="Title" data-content="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum feugiat sodales. In hac habitasse platea dictumst. Nunc blandit suscipit finibus. Donec sit amet venenatis tortor. Pellentesque vel posuere nunc." aria-hidden="true">Latitude</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="inputLat" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" data-toggle="popover" data-trigger="hover" title="Title" data-content="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum feugiat sodales. In hac habitasse platea dictumst. Nunc blandit suscipit finibus. Donec sit amet venenatis tortor. Pellentesque vel posuere nunc." aria-hidden="true">Longitude</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="inputLon" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" data-toggle="popover" data-trigger="hover" title="Title" data-content="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum feugiat sodales. In hac habitasse platea dictumst. Nunc blandit suscipit finibus. Donec sit amet venenatis tortor. Pellentesque vel posuere nunc." aria-hidden="true">Issue</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="inputIssue">
                                        <option selected value>None</option>
                                        <option value="no_label">No label present</option>
                                        <option value="multiple_specimens">Multiple speciments shown</option>
                                        <option value="problem_label">Problematic label</option>
                                    </select>
                                </div>
                            </div>
                            <i class="fa fa-chevron-circle-left fa-4x text-primary navSpecimen" aria-hidden="true" onclick="prevSpecimen()"></i>
                            <i class="fa fa-chevron-circle-right pull-right fa-4x text-primary navSpecimen" aria-hidden="true" onclick="nextSpecimen()"></i>
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
                var countries = [
                    { value: 'Andorra', data: 'AD' },
                    { value: 'Zimbabwe', data: 'ZZ' }
                ];

                jQuery('#inputLon').devbridgeAutocomplete({
                    lookup: countries,
                });

            </script>

		</section>
		<!-- /section -->
	</main>


<?php get_footer(); ?>

<script>
    jQuery('label').popover({placement:'bottom', container: 'body'})
</script>

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

		if (have_posts()): while (have_posts()) : the_post(); ?>

			<!-- article -->
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                <div class="row">
                    <div class="col-sm-8"> <!-- div for images -->
                        <div class="well">imgs here</div>
                    </div>
                    
                    <div class="col-sm-4"> <!-- div for form -->
                        <form class="form-horizontal" onsubmit="return false">
                            <div class="form-group">
                                <label class="col-sm-3 control-label" data-toggle="popover" data-trigger="hover" title="Title" data-content="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum feugiat sodales. In hac habitasse platea dictumst. Nunc blandit suscipit finibus. Donec sit amet venenatis tortor. Pellentesque vel posuere nunc." aria-hidden="true">Genus</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="inputGenus" placeholder="Anthurium">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" data-toggle="popover" data-trigger="hover" title="Title" data-content="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum feugiat sodales. In hac habitasse platea dictumst. Nunc blandit suscipit finibus. Donec sit amet venenatis tortor. Pellentesque vel posuere nunc." aria-hidden="true">Species</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="inputSpecies" placeholder="longipoda">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" data-toggle="popover" data-trigger="hover" title="Title" data-content="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum feugiat sodales. In hac habitasse platea dictumst. Nunc blandit suscipit finibus. Donec sit amet venenatis tortor. Pellentesque vel posuere nunc." aria-hidden="true">Authority</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="inputAuthor" placeholder="Schott">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" data-toggle="popover" data-trigger="hover" title="Title" data-content="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum feugiat sodales. In hac habitasse platea dictumst. Nunc blandit suscipit finibus. Donec sit amet venenatis tortor. Pellentesque vel posuere nunc." aria-hidden="true">Number</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="inputNumber" placeholder="436">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" data-toggle="popover" data-trigger="hover" title="Title" data-content="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum feugiat sodales. In hac habitasse platea dictumst. Nunc blandit suscipit finibus. Donec sit amet venenatis tortor. Pellentesque vel posuere nunc." aria-hidden="true">Collector</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="inputCollector" placeholder="Betancur">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" data-toggle="popover" data-trigger="hover" title="Title" data-content="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum feugiat sodales. In hac habitasse platea dictumst. Nunc blandit suscipit finibus. Donec sit amet venenatis tortor. Pellentesque vel posuere nunc." aria-hidden="true">Determiner</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="inputDeterminer" placeholder="Croat">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" data-toggle="popover" data-trigger="hover" title="Title" data-content="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum feugiat sodales. In hac habitasse platea dictumst. Nunc blandit suscipit finibus. Donec sit amet venenatis tortor. Pellentesque vel posuere nunc." aria-hidden="true">Herbarium</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="inputHerbarium" placeholder="COL">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" data-toggle="popover" data-trigger="hover" title="Title" data-content="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum feugiat sodales. In hac habitasse platea dictumst. Nunc blandit suscipit finibus. Donec sit amet venenatis tortor. Pellentesque vel posuere nunc." aria-hidden="true">Location</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="inputLocation" placeholder="el Taladro finca la Esperanza">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" data-toggle="popover" data-trigger="hover" title="Title" data-content="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum feugiat sodales. In hac habitasse platea dictumst. Nunc blandit suscipit finibus. Donec sit amet venenatis tortor. Pellentesque vel posuere nunc." aria-hidden="true">Latitude</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="inputLat" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" data-toggle="popover" data-trigger="hover" title="Title" data-content="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum feugiat sodales. In hac habitasse platea dictumst. Nunc blandit suscipit finibus. Donec sit amet venenatis tortor. Pellentesque vel posuere nunc." aria-hidden="true">Longitude</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="inputLon" placeholder="">
                                </div>
                            </div>
                            <i class="fa fa-chevron-circle-left fa-4x text-primary navSpecimen" aria-hidden="true" onclick="prevSpecimen()"></i>
                            <i class="fa fa-chevron-circle-right pull-right fa-4x text-primary navSpecimen" aria-hidden="true" onclick="nextSpecimen()"></i>
                        </form>
                    </div>
                </div>

			</article>
			<!-- /article -->

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

		<?php endwhile; ?>

		<?php else: ?>

			<!-- article -->
			<article>

				<h2><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h2>

			</article>
			<!-- /article -->

		<?php endif; ?>

		</section>
		<!-- /section -->
	</main>


<?php get_footer(); ?>

<script>
    jQuery('label').popover({placement:'bottom', container: 'body'})
</script>

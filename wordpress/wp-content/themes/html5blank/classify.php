<?php /* Template Name: Classify template */ get_header(); ?>

	<main role="main">
		<!-- section -->
		<section>

			<h1><?php the_title(); ?></h1>

		<?php if (have_posts()): while (have_posts()) : the_post(); ?>

			<!-- article -->
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                <div class="row">
                    <div class="col-sm-8"> <!-- div for images -->
                        <div class="well">imgs here</div>
                    </div>
                    
                    <div class="col-sm-4"> <!-- div for form -->
                        <form class="form-horizontal" onsubmit="return false">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Genus</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputGenus" placeholder="Anthurium">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Species</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputSpecies" placeholder="longipoda">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Number</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputNumber" placeholder="436">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Collector</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputCollector" placeholder="Betancur">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">???</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputXXX" placeholder="Croat">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Location</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputLocation" placeholder=" el Taladro finca la Esperanza">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Lat.</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputLat" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Long.</label>
                                <div class="col-sm-10">
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

<?php /* Template Name: Annotate specimens template */ 

/*

Simple upload form that submits to itself as a POST
expecting a CSV file which was contains the data
associated with the annoated specimens.

JSON 

*/


get_header(); ?>

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

                <?php if ( isset($_FILES['datafile']) ) {
                    // process file if it was submitted
                    process_csv_upload($_FILES['datafile']);
                }?>

                <p>This page is used to label multiple specimens in batch form through the use of a CSV.</p>

                <div class="row">
                    <div class="col-sm-7">
                        <h3>Process for adding data to specimens in the database</h3>
                        <ol>
                            <li>Generate CSV of annotated information, the first column must be named <code>File</code> and must contain data for a JPG filename and the remaining columns must contain the input metadata and must be one of the following: <code>inputCollector</code>, <code>inputHerbarium</code>, <code>inputGenus</code>, <code>inputNumber</code>, <code>inputSpecies</code>, <code>inputSection</code>, <code>inputCountry</code>, <code>inputDepartment</code>, <code>inputMunicipality</code></li>
                            <li>The name listed in the first column (file) will be searched against the name of an image in the Media section. If an exact match is found and a specimen ID (internal WP ID) is associated with the found image, the CSV data for that image will be associated with that specimen.</li>
                        </ol>
                    </div>
                    <div class="col-sm-5">
                        <h3>Upload CSV</h3>
                        <form method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <input type="file" name="datafile" required>
                            </div>
                            <button type="submit" class="btn btn-info pull-right">Submit</button>
                        </form>
                    </div>
                </div>

			</article>
			<!-- /article -->

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


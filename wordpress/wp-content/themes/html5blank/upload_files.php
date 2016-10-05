<?php /* Template Name: Upload files template */ 

/*

Simple upload form that submits to itself as a POST
expecting a JSON file which was generated with the
process_imgs.py script.

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
                    process_file_upload($_FILES['datafile']);
                }?>

                <div class="row">
                    <div class="col-sm-7">
                        <h3>Process associating images to specimens</h3>
                        <ol>
                            <li>Run script <code>process_imgs.py</code> (for now this is done locally) to classify images into specimen, rotate them and generate the <mark>results.json</mark> file.</li>
                            <li>Once images are properly rotated, upload them through the WP media back-end.</li>
                            <li>Upload the resulting <mark>results.json</mark> file on this page.  This will add the specimens to the database and make it accessible for <a href='/classify'>classifying</a> further.</li>
                        </ol>
                    </div>
                    <div class="col-sm-5">
                        <h3>Upload JSON</h3>
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


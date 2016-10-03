<?php /* Template Name: Add media template */ 

/*

Add images that have been uploaded through
FTP to the media section

*/


get_header(); ?>

	<main role="main">
		<!-- section -->
		<section>

			<h1><?php the_title(); ?></h1>

        <?php // only show form if a user is logged in
        if ( !is_user_logged_in() && !current_user_can( 'manage_options' ) ) {
            echo sprintf('<p class="lead login-link">You must <a href="%s">sign in</a> to view this page.</p>', wp_login_url( get_permalink() ) );
            return;
        };


        add_media_from_ftp();
        ?>

        <script>
            //updateMedia();
        </script>

		</section>
		<!-- /section -->
	</main>


<?php get_footer(); ?>


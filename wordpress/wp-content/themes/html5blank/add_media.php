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

			<!-- article -->
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                <p>Page is a place-holder page which simply runs the function add_media_from_ftp(); I've been using it to do various back-end stuffs. Currently the function does nothing.</p>

                <?php // only show form if a user is logged in
                if ( !is_user_logged_in() && !current_user_can( 'manage_options' ) ) {
                    echo sprintf('<p class="lead login-link">You must <a href="%s">sign in</a> to view this page.</p>', wp_login_url( get_permalink() ) );
                    return;
                };

                add_media_from_ftp();
                ?>

            </article>

		</section>
		<!-- /section -->
	</main>


<?php get_footer(); ?>


<?php /* Template Name: Add new specimen template */ 

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
        ?>

        <p>Will add a new specimen with the given images.</p>

        <div id="results"></div> <!-- automatically filled by ajax response -->

        <form onsubmit="addNewSpecimen(); return false">
          <div class="form-group">
            <label for="images">Images (comma separated, no spaces)</label>
            <input type="text" class="form-control" id="images" placeholder="DSC0123.jpg,DSC01234.jpg" required>
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>


		</section>
		<!-- /section -->
	</main>


<?php get_footer(); ?>


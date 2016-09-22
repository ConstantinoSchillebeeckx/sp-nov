<?php /* Template Name: Search specimens template */ 

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
        };?>


			<!-- article -->
			<article>

                <div class="row">
                    <div class="col-sm-11">
                        <div id="builder"></div>
                    </div>
                    <div class="col-sm-1">
                        <button style="margin-top:4px" class="btn btn-primary pull-right" type="button" onclick="searchSpecimen()">Search</button>
                    </div>
                </div>
                <div class="row" style="margin-top:10px">
                    <div class="col-sm-12" id="searchResults">
                    </div>
                </div>

                <script>
                    var options = {
                        allow_empty: true,
                        filters: [
                          {
                            id: 'Genus',
                            type: 'string',
                            //optgroup: 'core',
                            default_value: 'Anthurium',
                            size: 30,
                            unique: true
                          }
                        ]
                    };


                    jQuery('#builder').queryBuilder(options);

                    function searchSpecimen() {
                        var rules = jQuery('#builder').queryBuilder('getSQL');
                        console.log(rules);
                    }

                    jQuery('#builder').on('validationError.queryBuilder', function(e, rule, error, value) {
                        console.log(rule, error, value);
                    });
                </script>

			</article>
			<!-- /article -->


		</section>
		<!-- /section -->
	</main>


<?php get_footer(); ?>


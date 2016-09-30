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

            <div class="row">
                <div class="col-sm-4">
                    <h1><?php the_title(); ?></h1>
                </div>
            </div>



        <?php // only show form if a user is logged in
        if ( !is_user_logged_in() ) {
            echo sprintf('<p class="lead login-link">You must <a href="%s">sign in</a> to view this page.</p>', wp_login_url( get_permalink() ) );
            return;
        };?>


			<!-- article -->
			<article>

                <div class="row">
                    <div class="col-sm-12">
                            <div class="btn-group pull-right">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Download <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu pull-right">
                                    <li><a href="#" id="downloadRename">Renamed filenames</a></li>
                                    <li><a href="#" id="downloadOriginal">Original filenames</a></li>
                                    <li><a href="#" id="downloadTropicos">Tropicos CSV</a></li>
                                </ul>
                            </div>
                            <button style="margin-right:5px" class="btn btn-info pull-right" type="button" onclick="searchSpecimen()">Search</button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div id="builder"></div>
                    </div>
                </div>
                <div class="row" style="margin-top:10px">
                    <div class="col-sm-12" id="searchResults">
                    </div>
                </div>

                <script>
                    jQuery('#builder').queryBuilder(builderOptions);

                    // customize tooltip error message
                    // https://github.com/mistic100/jQuery-QueryBuilder/issues/362#issuecomment-249010070
                    jQuery('#builder').on('validationError.queryBuilder', function(e, node, error, value) {
                        if (error[1] == '/^[a-zA-Z]+$/') {
                            error[0] = "Please enter only letters.";
                        } else if (error[1] == '/^[a-zA-Z1-9]+$/') {
                            error[0] = "Please enter only letters or numbers.";
                        } else if (error[1] == '/^[1-9]+$/') {
                            error[0] = "Please enter only numbers.";
                        }
                    });
                </script>

                <script>
                    // handle button click for download
                    jQuery("#downloadRename").click(function(e){
                        downloadSpecimens(true);
                        e.preventDefault();
                    });
                    jQuery("#downloadOriginal").click(function(e){
                        downloadSpecimens(false);
                        e.preventDefault();
                    });
                    jQuery("#downloadTropicos").click(function(e){
                        downloadTropicosCSV();
                        e.preventDefault();
                    });
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

			</article>
			<!-- /article -->


		</section>
		<!-- /section -->
	</main>


<?php get_footer(); ?>


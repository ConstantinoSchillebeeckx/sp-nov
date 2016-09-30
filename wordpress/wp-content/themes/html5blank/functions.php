<?php
/**
 * Author: Todd Motto | @toddmotto
 * URL: html5blank.com | @html5blank
 * Custom functions, support, custom post types and more.
 */

require_once "modules/is-debug.php";
require_once "modules/nav-walker.php";

/*------------------------------------*\
    External Modules/Files
\*------------------------------------*/

// Load any external files you have here

/*------------------------------------*\
    Theme Support
\*------------------------------------*/

if (!isset($content_width))
{
    $content_width = 900;
}

if (function_exists('add_theme_support'))
{

    // Add Thumbnail Theme Support
    add_theme_support('post-thumbnails');
    add_image_size('large', 0, 0, true); // Large Thumbnail
    add_image_size('medium', 0, 0, true); // Medium Thumbnail
    add_image_size('small', 0, 0, true); // Small Thumbnail
    add_image_size('custom-size', 0, 0, true); // Custom Thumbnail Size call using the_post_thumbnail('custom-size');

    // Add Support for Custom Backgrounds - Uncomment below if you're going to use
    /*add_theme_support('custom-background', array(
    'default-color' => 'FFF',
    'default-image' => get_template_directory_uri() . '/img/bg.jpg'
    ));*/

    // Add Support for Custom Header - Uncomment below if you're going to use
    /*add_theme_support('custom-header', array(
    'default-image'          => get_template_directory_uri() . '/img/headers/default.jpg',
    'header-text'            => false,
    'default-text-color'     => '000',
    'width'                  => 1000,
    'height'                 => 198,
    'random-default'         => false,
    'wp-head-callback'       => $wphead_cb,
    'admin-head-callback'    => $adminhead_cb,
    'admin-preview-callback' => $adminpreview_cb
    ));*/

    // Enables post and comment RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Localisation Support
    load_theme_textdomain('html5blank', get_template_directory() . '/languages');
}

/*------------------------------------*\
    Functions
\*------------------------------------*/

// HTML5 Blank navigation
function html5blank_nav()
{
    $menu = '<div class="collapse navbar-collapse" id="nav-collapse"><ul class="nav navbar-nav navbar-right">';
    $menu .= wp_nav_menu(
    array(
        'theme_location'  => 'header-menu',
        'menu'            => '',
        'container'       => 'div',
        'container_class' => 'menu-{menu slug}-container',
        'container_id'    => '',
        'menu_class'      => 'menu',
        'menu_id'         => '',
        'echo'            => false,
        'fallback_cb'     => 'wp_page_menu',
        'before'          => '',
        'link_before'     => '',
        'link_after'      => '',
        'items_wrap'      => '%3$s',
        'depth'           => 0,
        'walker' => new bootstrap_navbar_walker()
        )
    );

    // if user is logged in, show a 'log out' menu; otherwise a 'log in' menu
    if (is_user_logged_in()) {
        $menu .= sprintf("<li><a href='%s'>Logout</a></li>", wp_logout_url());
    } else {
        $menu .= sprintf("<li><a href='%s'>Login</a></li>", wp_login_url( get_permalink() ) );
    }
    echo $menu;
//    get_template_part('searchform');
}

// Load HTML5 Blank scripts (header.php)
function html5blank_header_scripts()
{
    wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js');
    wp_enqueue_script('jquery');

    wp_register_script('bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js');
    wp_enqueue_script('bootstrap');
    wp_enqueue_style('bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css');
    wp_enqueue_style('font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css');

    wp_register_script('conditionizr', get_template_directory_uri() . '/js/lib/conditionizr-4.3.0.min.js', array(), '4.3.0');
    wp_enqueue_script('conditionizr');


}








// Load HTML5 Blank conditional scripts
function html5blank_conditional_scripts()
{
    if (is_page('classify') || is_page('upload') || is_page('search')) {
        // Custom scripts
        wp_enqueue_script('spnov_scripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), '1.0.0');
        wp_localize_script( 'spnov_scripts', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) ); // required to do AJAX!

        wp_enqueue_script('formInputs', get_template_directory_uri() . '/js/formInputs.js', array('jquery'), '1.0.0');
        //wp_enqueue_script('requirejs', 'https://cdnjs.cloudflare.com/ajax/libs/require.js/2.3.2/require.min.js');
        //wp_enqueue_script('json2csv', 'https://cdn.rawgit.com/zemirco/json2csv/master/lib/json2csv.js');


        wp_register_script('autocomplete', get_template_directory_uri() . '/js/lib/jquery.autocomplete.min.js', array('jquery'), '1.2.26');
        wp_enqueue_script('autocomplete');

        wp_enqueue_style('autocomplete_css', get_template_directory_uri() . '/css/jquery.autocomplete.css', array(), '1.2.26');
    }

    if (is_page('search')) {
        wp_enqueue_script('query_builder', get_template_directory_uri() . '/js/query-builder.js', array('jquery'));
        wp_enqueue_style('query_builder_css', get_template_directory_uri() . '/css/query-builder.css');
    }
}

// Load HTML5 Blank styles
function html5blank_styles()
{
    if (HTML5_DEBUG) {
        // normalize-css
        wp_register_style('normalize', get_template_directory_uri() . '/bower_components/normalize.css/normalize.css', array(), '3.0.1');

        // Custom CSS
        wp_register_style('html5blank', get_template_directory_uri() . '/style.css', array('normalize'), '1.0');

        // Register CSS
        wp_enqueue_style('html5blank');
    } else {
        // Custom CSS
        wp_register_style('html5blankcssmin', get_template_directory_uri() . '/style.css', array(), '1.0');
        // Register CSS
        wp_enqueue_style('html5blankcssmin');
    }
}

// Register HTML5 Blank Navigation
function register_html5_menu()
{
    register_nav_menus(array( // Using array to specify more menus if needed
        'header-menu' => __('Header Menu', 'html5blank'), // Main Navigation
        'sidebar-menu' => __('Sidebar Menu', 'html5blank'), // Sidebar Navigation
        'extra-menu' => __('Extra Menu', 'html5blank') // Extra Navigation if needed (duplicate as many as you need!)
    ));
}

// Remove the <div> surrounding the dynamic navigation to cleanup markup
function my_wp_nav_menu_args($args = '')
{
    $args['container'] = false;
    return $args;
}

// Remove Injected classes, ID's and Page ID's from Navigation <li> items
function my_css_attributes_filter($var)
{
    return is_array($var) ? array() : '';
}

// Remove invalid rel attribute values in the categorylist
function remove_category_rel_from_category_list($thelist)
{
    return str_replace('rel="category tag"', 'rel="tag"', $thelist);
}

// Add page slug to body class, love this - Credit: Starkers Wordpress Theme
function add_slug_to_body_class($classes)
{
    global $post;
    if (is_home()) {
        $key = array_search('blog', $classes);
        if ($key > -1) {
            unset($classes[$key]);
        }
    } elseif (is_page()) {
        $classes[] = sanitize_html_class($post->post_name);
    } elseif (is_singular()) {
        $classes[] = sanitize_html_class($post->post_name);
    }

    return $classes;
}

// Remove the width and height attributes from inserted images
function remove_width_attribute( $html ) {
   $html = preg_replace( '/(width|height)="\d*"\s/', "", $html );
   return $html;
}


// If Dynamic Sidebar Exists
if (function_exists('register_sidebar'))
{
    // Define Sidebar Widget Area 1
    register_sidebar(array(
        'name' => __('Widget Area 1', 'html5blank'),
        'description' => __('Description for this widget-area...', 'html5blank'),
        'id' => 'widget-area-1',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));

    // Define Sidebar Widget Area 2
    register_sidebar(array(
        'name' => __('Widget Area 2', 'html5blank'),
        'description' => __('Description for this widget-area...', 'html5blank'),
        'id' => 'widget-area-2',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));
}

// Remove wp_head() injected Recent Comment styles
function my_remove_recent_comments_style()
{
    global $wp_widget_factory;
    remove_action('wp_head', array(
        $wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
        'recent_comments_style'
    ));
}

// Pagination for paged posts, Page 1, Page 2, Page 3, with Next and Previous Links, No plugin
function html5wp_pagination()
{
    global $wp_query;
    $big = 999999999;
    echo paginate_links(array(
        'base' => str_replace($big, '%#%', get_pagenum_link($big)),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $wp_query->max_num_pages
    ));
}

// Custom Excerpts
function html5wp_index($length) // Create 20 Word Callback for Index page Excerpts, call using html5wp_excerpt('html5wp_index');
{
    return 20;
}

// Create 40 Word Callback for Custom Post Excerpts, call using html5wp_excerpt('html5wp_custom_post');
function html5wp_custom_post($length)
{
    return 40;
}

// Create the Custom Excerpts callback
function html5wp_excerpt($length_callback = '', $more_callback = '')
{
    global $post;
    if (function_exists($length_callback)) {
        add_filter('excerpt_length', $length_callback);
    }
    if (function_exists($more_callback)) {
        add_filter('excerpt_more', $more_callback);
    }
    $output = get_the_excerpt();
    $output = apply_filters('wptexturize', $output);
    $output = apply_filters('convert_chars', $output);
    $output = '<p>' . $output . '</p>';
    echo $output;
}

// Custom View Article link to Post
function html5_blank_view_article($more)
{
    global $post;
    return '... <a class="view-article" href="' . get_permalink($post->ID) . '">' . __('View Article', 'html5blank') . '</a>';
}

// Remove Admin bar
function remove_admin_bar()
{
    return false;
}

// Remove 'text/css' from our enqueued stylesheet
function html5_style_remove($tag)
{
    return preg_replace('~\s+type=["\'][^"\']++["\']~', '', $tag);
}

// Remove thumbnail width and height dimensions that prevent fluid images in the_thumbnail
function remove_thumbnail_dimensions( $html )
{
    $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
    return $html;
}

// Custom Gravatar in Settings > Discussion
function html5blankgravatar ($avatar_defaults)
{
    $myavatar = get_template_directory_uri() . '/img/gravatar.jpg';
    $avatar_defaults[$myavatar] = "Custom Gravatar";
    return $avatar_defaults;
}

// Threaded Comments
function enable_threaded_comments()
{
    if (!is_admin()) {
        if (is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
            wp_enqueue_script('comment-reply');
        }
    }
}

// Custom Comments Callback
function html5blankcomments($comment, $args, $depth)
{
    $GLOBALS['comment'] = $comment;
    extract($args, EXTR_SKIP);

    if ( 'div' == $args['style'] ) {
        $tag = 'div';
        $add_below = 'comment';
    } else {
        $tag = 'li';
        $add_below = 'div-comment';
    }
?>
    <!-- heads up: starting < for the html tag (li or div) in the next line: -->
    <<?php echo $tag ?> <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
    <?php if ( 'div' != $args['style'] ) : ?>
    <div id="div-comment-<?php comment_ID() ?>" class="comment-body">
    <?php endif; ?>
    <div class="comment-author vcard">
    <?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['avatar_size'] ); ?>
    <?php printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>'), get_comment_author_link()) ?>
    </div>
<?php if ($comment->comment_approved == '0') : ?>
    <em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.') ?></em>
    <br />
<?php endif; ?>

    <div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">
        <?php
            printf( __('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)'),'  ','' );
        ?>
    </div>

    <?php comment_text() ?>

    <div class="reply">
    <?php comment_reply_link(array_merge( $args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
    </div>
    <?php if ( 'div' != $args['style'] ) : ?>
    </div>
    <?php endif; ?>
<?php }

/*------------------------------------*\
    Actions + Filters + ShortCodes
\*------------------------------------*/

// Add Actions
add_action('init', 'html5blank_header_scripts'); // Add Custom Scripts to wp_head
add_action('wp_print_scripts', 'html5blank_conditional_scripts'); // Add Conditional Page Scripts
add_action('get_header', 'enable_threaded_comments'); // Enable Threaded Comments
add_action('wp_enqueue_scripts', 'html5blank_styles'); // Add Theme Stylesheet
add_action('init', 'register_html5_menu'); // Add HTML5 Blank Menu
add_action('widgets_init', 'my_remove_recent_comments_style'); // Remove inline Recent Comment Styles from wp_head()
add_action('init', 'html5wp_pagination'); // Add our HTML5 Pagination

// Remove Actions
remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
remove_action('wp_head', 'rsd_link'); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action('wp_head', 'wlwmanifest_link'); // Display the link to the Windows Live Writer manifest file.
remove_action('wp_head', 'wp_generator'); // Display the XHTML generator that is generated on the wp_head hook, WP version
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

// Add Filters
add_filter('avatar_defaults', 'html5blankgravatar'); // Custom Gravatar in Settings > Discussion
add_filter('body_class', 'add_slug_to_body_class'); // Add slug to body class (Starkers build)
add_filter('widget_text', 'do_shortcode'); // Allow shortcodes in Dynamic Sidebar
add_filter('widget_text', 'shortcode_unautop'); // Remove <p> tags in Dynamic Sidebars (better!)
add_filter('wp_nav_menu_args', 'my_wp_nav_menu_args'); // Remove surrounding <div> from WP Navigation
// add_filter('nav_menu_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected classes (Commented out by default)
// add_filter('nav_menu_item_id', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected ID (Commented out by default)
// add_filter('page_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> Page ID's (Commented out by default)
add_filter('the_category', 'remove_category_rel_from_category_list'); // Remove invalid rel attribute
add_filter('the_excerpt', 'shortcode_unautop'); // Remove auto <p> tags in Excerpt (Manual Excerpts only)
add_filter('the_excerpt', 'do_shortcode'); // Allows Shortcodes to be executed in Excerpt (Manual Excerpts only)
add_filter('excerpt_more', 'html5_blank_view_article'); // Add 'View Article' button instead of [...] for Excerpts
add_filter('show_admin_bar', 'remove_admin_bar'); // Remove Admin bar
add_filter('style_loader_tag', 'html5_style_remove'); // Remove 'text/css' from enqueued stylesheet
add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to thumbnails
add_filter('post_thumbnail_html', 'remove_width_attribute', 10 ); // Remove width and height dynamic attributes to post images
add_filter('image_send_to_editor', 'remove_width_attribute', 10 ); // Remove width and height dynamic attributes to post images

// Remove Filters
remove_filter('the_excerpt', 'wpautop'); // Remove <p> tags from Excerpt altogether
remove_filter('the_content', 'wpautop'); // Remove <p> tags from Content altogether

// Shortcodes
add_shortcode('html5_shortcode_demo', 'html5_shortcode_demo'); // You can place [html5_shortcode_demo] in Pages, Posts now.
add_shortcode('html5_shortcode_demo_2', 'html5_shortcode_demo_2'); // Place [html5_shortcode_demo_2] in Pages, Posts now.

// Shortcodes above would be nested like this -
// [html5_shortcode_demo] [html5_shortcode_demo_2] Here's the page title! [/html5_shortcode_demo_2] [/html5_shortcode_demo]

/*------------------------------------*\
    ShortCode Functions
\*------------------------------------*/

// Shortcode Demo with Nested Capability
function html5_shortcode_demo($atts, $content = null)
{
    return '<div class="shortcode-demo">' . do_shortcode($content) . '</div>'; // do_shortcode allows for nested Shortcodes
}

// Shortcode Demo with simple <h2> tag
function html5_shortcode_demo_2($atts, $content = null) // Demo Heading H2 shortcode, allows for nesting within above element. Fully expandable.
{
    return '<h2>' . $content . '</h2>';
}



/*------------------------------------*\
	Custom Post Types
\*------------------------------------*/

// Create custom post type for tasks
// https://premium.wpmudev.org/blog/creating-content-custom-post-types/
function spnov_create_post_type()
{
    register_post_type('specimen', // Register Custom Post Type
        array(
        'labels' => array(
            'name' => __('Specimen', 'spnov'), // Rename these to suit
            'singular_name' => __('Specimen', 'spnov'),
            'add_new' => __('Add New', 'spnov'),
            'add_new_item' => __('Add New Specimen', 'spnov'),
            'edit' => __('Edit', 'spnov'),
            'edit_item' => __('Edit Specimen', 'spnov'),
            'new_item' => __('New Specimen', 'spnov'),
            'view' => __('View Specimen', 'spnov'),
            'view_item' => __('View Specimen', 'spnov'),
            'search_items' => __('Search Specimen', 'spnov'),
            'not_found' => __('No Specimens found', 'spnov'),
            'not_found_in_trash' => __('No Specimen found in Trash', 'spnov')
        ),
        'public' => true,
        'hierarchical' => false, // Allows your posts to behave like Hierarchy Pages
        'has_archive' => true,
        'supports' => array(
			'title',
			'editor',
            'author',
			'custom-fields',
			'page-attributes',
			'revisions',
		),
		'exclude_from_search' => false,
        'can_export' => true, // Allows export in Tools > Expor
		'capability_type' => 'post',
		'rewrite' => array( 'slug' => 'specimen' )
    ));
	flush_rewrite_rules();
}
add_action('init', 'spnov_create_post_type'); // Add our Task Type


/* Add a custome post type Specimen to db

Parameters:
----------
- $dat : assoc array
         output from the process_file_upload() function which is
         the parsed JSON file where each key is a specimen ID
         (which we don't actually care about) and the value is
         an array of image names associated with the specimen


*/
function spnov_add_specimen( $dat ) {

    $current_user = wp_get_current_user();

    // create a new custom post type (Specimen) for each specimen in JSON
    foreach ($dat as $id => $imgs) {

         // Create post object
         // contains the following data https://codex.wordpress.org/Class_Reference/WP_Post
         // all other data stored as meta data
        $my_post = array(
            'post_type'     => 'specimen',
            'post_author'   => sanitize_user( $current_user->ID ),
            'post_status'   => 'publish',
        );

        // Insert the post into the database
        $post_id = wp_insert_post( $my_post );
        if ($post_id != 0) { // if successfully added specimen, update the metadata

            // add array of associated images to specimen
            // this will be stored as a comma separated string
            // so that it is visible in the backend as a custom field
            if (!add_post_meta( $post_id, 'imgs', implode(',',$imgs) )) {
                return 'Set imgs error'; // if error
            }

            // set post title as the post ID
            if (!wp_update_post( array('ID' => $post_id, 'post_title' => $post_id) )) {
                return 'Post title error'; // if error
            }

            // set status
            if (!add_post_meta( $post_id, 'status', 'unfinished' )) {
                return 'Finished status error'; // if error
            }

            // set download status
            if (!add_post_meta( $post_id, 'downloaded', false )) {
                return 'Download status error'; // if error
            }

            // set post parent (image "attached to")
            // use title (_wp_attached_file) and postmeta to find post_id
            foreach ($imgs as $img_name) {
                $tmp_id = get_post_id_from_meta('_wp_attached_file',$img_name);
                if (!$tmp_id) { // images don't exist in media, remove added specimen
                    wp_delete_post($post_id, true);
                } else {
                    if (!wp_update_post( array('ID' => $tmp_id, 'post_parent' => $post_id) )){
                        return 'Couldn\'t attach image';
                    }
                } 
            }

        } else {
            return false;
        }

    }

    return true;

}


/*

Used to lookup the post_id when only
the a postmeta key & value are known

Parameters:
-----------
- $key : str
         postmeta key
- $val : str
         postmeta value

Returns:
--------
- post_id associated with postmeta key/value


*/
function get_post_id_from_meta($key, $val) {
    global $wpdb;
    $query = "SELECT post_id FROM $wpdb->postmeta where meta_key = '$key' and meta_value = '$val'";

    return $wpdb->get_var( $query );
}







/* function called from Upload template everytime
 a file is submitted

Parameters:
-----------
- $dat : assoc array
         $_FILES from the upload submit form
         will have keys: name, type, tmp_name, error, size

*/
function process_file_upload($dat) {

    // ensure file was json and there was no error
    if ($dat['type'] == 'application/json' && $dat['error'] == 0) {
        $json = json_decode(file_get_contents($dat['tmp_name']), true);
        $add_specimen = spnov_add_specimen($json);
        if ($add_specimen === true) {
            echo sprintf('<p class="lead">Great! %s speciments were properly uploaded.', count($json) );
        } else {
            echo '<p class="lead">Some sort of error occurred when adding a specimen to the databse...</p>';
            echo $add_specimen;
        }
    } else {
        echo '<p class="lead">Something went wrong, please make sure file is JSON formatted and try again.</p>';
    }

}






/* Function called by AJAX auto_complete library

Parameters:
-----------
- $_GET['key'] : str
                 specimen data key being looked up
                 e.g. inputGenus
- $_GET['query'] : str
                   string being typed in the input box

Returns:
--------
json encoded string in the format ['suggestions': [str, str, str,]]

*/
add_action( 'wp_ajax_autoComplete', 'autoComplete_callback' );
function autoComplete_callback() {

    global $wpdb;
    $key = sanitize_text_field( $_GET['key'] );
    $query = sanitize_text_field( $_GET['query'] );

    $vals = $wpdb->get_col( "SELECT DISTINCT(meta_value) FROM $wpdb->postmeta WHERE meta_key = '$key' AND meta_value like '%$query%'" );

    echo json_encode( array('suggestions' => $vals ) );

    wp_die(); // this is required to terminate immediately and return a proper response

}








/* Function called by AJAX to search for specimens


Parameters:
-----------
- $_GET['ids'] : array
                 list of wordpress IDs to download
- $_GET['rename'] : bool
                    if true, images will be renamed within zip
                    (renamed to BoGart guidelines)
- $_GET['onlyNotDownloaded'] : bool
                    if true, allow only download of undownloaded specimens
                    specimens that have been previously downloaded will have
                    a date set for the meta_key=downloaded
Returns:
--------
json_encode with url: link to download
*/
add_action( 'wp_ajax_downloadSpecimens', 'downloadSpecimens_callback' );
function downloadSpecimens_callback() {

    global $wpdb;
    $ids = implode(',', $_GET['ids']);
    $only_not_downloaded = json_decode($_GET['onlyNotDownloaded']);

    // location of imgs
    $dir = '~/domains/spnov.com/html/wordpress/wp-content/uploads/';

    // run query for specimen info
    if ($only_not_downloaded) {
        $query = "SELECT post_id, meta_key, meta_value FROM $wpdb->postmeta WHERE post_id in (SELECT post_id FROM $wpdb->postmeta where meta_key = 'downloaded' and meta_value = '' and post_id in ($ids))";
    } else {
        $query = "SELECT post_id, meta_key, meta_value FROM $wpdb->postmeta WHERE post_id in ($ids)";
    }
    $dat = $wpdb->get_results( $query, ARRAY_A ); 

    if (!count($dat)) {
        echo json_encode(array('success' => false, 'msg' => '<p class="lead">Nothing to download (only specimens that haven\'t already been downloaded are available for download).</p>', 'dat'=>$only_not_downloaded));
        wp_die();
        return;
    }

    // reformat query results and get list of imgs
    // [post_id => array(meta_key => meta_value, ...)]
    $dat_clean = [];
    $imgs = []; // list of imgs with full local path
    foreach ($dat as $row) {
        $id = $row['post_id'];
        $meta_key = $row['meta_key'];
        $meta_value = $row['meta_value'];

        // if on imgs meta_key, add it to the command
        if ($meta_key == 'imgs') {
            foreach (explode(',', $meta_value) as $img) {
                $imgs[] = $dir . str_replace('JPG','jpg', $img);
            }
        }

        // store remaining data
        if ($dat_clean[$id]) {
            $dat_clean[$id][$meta_key] = $meta_value;
        } else {
            $dat_clean[$id] = array($meta_key => $meta_value);
        }
    }   

    // create bash command to generate zip and symlink
    if (count($imgs)) {

        // rename files before zipping
        if ( json_decode($_GET['rename']) ) { 
            $command = rename_specimens($dat_clean, $dir);
            $comm = 'rm ~/data/tmp/imgs.zip; zip -r9 -j ~/data/tmp/imgs.zip ~/data/tmp/*jpg; rm ~/data/tmp/*jpg; ln -s ~/data/tmp/imgs.zip ~/domains/spnov.com/html/;';
        } else {
            $comm = 'rm ~/data/tmp/imgs.zip; zip -r9 -j ~/data/tmp/imgs.zip ' . implode(' ',$imgs) .'; ln -s ~/data/tmp/imgs.zip ~/domains/spnov.com/html/';
        }

        // execute command
        exec($comm, $out, $status);
    }

    // update downloaded meta_key to the current date
    if (count($ids)) {
        $date = date("Y-m-d");
        $update_query = "UPDATE $wpdb->postmeta SET meta_value = '$date' WHERE meta_key = 'downloaded' and post_id in ($ids)";
        $update = $wpdb->query($update_query);
    }

    // return
    if ($status) {
        echo json_encode(array('update'=>$comm, 'success' => true, 'url' => '/download.php', 'ids'=>$ids, 'status'=>$status, 'query'=>$query, 'dat'=>$dat_clean, 'imgs'=>$imgs)); // user can download file by visiting http://spnov.com/download.php
    } else {
        echo json_encode(array('success' => false, 'msg' => '<p class="lead">There was a problem generating the zip, please try again.</p>', 'comm'=>$comm, 'out' => $out, 'status' => $status));
    }

    wp_die();
}








/* Rename specimen images to BoGart guidelines

Will rename a given specimen JPG with the metadata
associated with the specimen per the BoGart guidelines.
Function will then keep original file, but generate a 
renamed copy in ~/data/tmp/

Function assumes all images in meta_key=imgs are specimens
except for the last one, which is considered a label

Parameters:
-----------
- $dat : assoc arr
         [wp id => [specimen_key: specimen_value]
- $dir : str
         path to location of image (e.g. wp uploads)

*/
function rename_specimens($dat, $dir) {

    $comms = [];
    foreach($dat as $id => $obj) {
        $count = 1;
        $imgs = explode(',', $obj['imgs']);
        foreach($imgs as $img) {
            $source_image = str_replace('JPG','jpg', $img);

            $comma_sep = [];
            $space_sep = [];
            if (isset($obj['inputGenus']) && $obj['inputGenus'] != '') $space_sep[] = $obj['inputGenus'];
            if (isset($obj['inputSection']) && $obj['inputSection'] != '') $space_sep[] = $obj['inputSection'];
            if (isset($obj['inputSpecies']) && $obj['inputSpecies'] != '') $space_sep[] = $obj['inputSpecies'];
            if (isset($obj['inputNumber']) && $obj['inputNumber'] != '') $space_sep[] = $obj['inputNumber'];
            if (isset($obj['inputCollector']) && $obj['inputCollector'] != '') $comma_sep[] = $obj['inputCollector'];
            if (isset($obj['inputDeterminer']) && $obj['inputDeterminer'] != '') $comma_sep[] = $obj['inputDeterminer'];
            if (isset($obj['inputHerbarium']) && $obj['inputHerbarium'] != '') $comma_sep[] = $obj['inputHerbarium'];
            if (isset($obj['inputLocation']) && $obj['inputLocation'] != '') $comma_sep[] = $obj['inputLocation'];

            // generate new name; replace spaces with \
            if (count($comma_sep)) {
                $space_part = implode('\ ', $space_sep);
                if (count($comma_sep)) {
                    $comma_part = str_replace(' ', '\ ', implode(', ', $comma_sep));
                    $rename_image = $space_part . '\ ' . $comma_part;
                } else {
                    $rename_image = $space_part;
                }

                if ($count == count($imgs)) {
                     $rename_image .= '\ label.jpg';
                } else {
                     $rename_image .= '\ '. $count . '.jpg';
                }
            } else { // if no data available for specimen, keep original name
                $rename_image = $source_image;
            }

            $comm = "cp " . $dir . $source_image . " ~/data/tmp/" . $rename_image;
            exec($comm, $out, $status);
            $count += 1;
            $comms[] = $comm;
        }
    }
    return $comms;
}








/* Function called by AJAX to download specimen data as CSV

Parameters:
-----------
- $_GET['ids'] : array
                 list of wordpress IDs to download
- $_GET['colMap'] : assoc array
                    [inputGenus => Genus, ...]

Returns:
--------
assoc array where each key is a WP specimen ID
and each value is another assoc array where
key is meta_key and value is meta_value
*/
add_action( 'wp_ajax_downloadTropicosCSV', 'downloadTropicosCSV_callback' );
function downloadTropicosCSV_callback() {

    global $wpdb;
    $ids = implode(',', $_GET['ids']);
    $cols = array_keys($_GET['colMap']);


    // run query for specimen info
    $query = "SELECT post_id, meta_key, meta_value FROM $wpdb->postmeta WHERE post_id in ($ids)";
    $dat = $wpdb->get_results( $query, ARRAY_A ); 

    if (!count($dat)) {
        echo json_encode(array('success' => false, 'msg' => '<p class="lead">Nothing to download (only specimens that haven\'t already been downloaded are available for download).</p>', 'dat'=>$only_not_downloaded));
        wp_die();
        return;
    }

    // reformat query results
    // [post_id => array(meta_key => meta_value, ...)]
    $dat_clean = [];
    foreach ($dat as $row) {
        $id = $row['post_id'];
        $meta_key = $row['meta_key'];
        $meta_value = $row['meta_value'];

        // store data if it has required column
        if (in_array($meta_key, $cols) && !in_array($meta_key, array('downloaded','status'))) {
            if ($dat_clean[$id]) {
                $dat_clean[$id][$meta_key] = $meta_value;
            } else {
                $dat_clean[$id] = array($meta_key => $meta_value);
            }
        }
    }   

    echo json_encode(array('dat' => $dat_clean));
    wp_die();
}







/* Function called by AJAX to search for specimens

Parameters:
-----------
- $_GET['dat'] : assoc array
                 see: http://querybuilder.js.org/demo.html
- $_GET['cols'] : array
                  array of columns (meta_key) requested
Returns:
--------
assoc array where each key is a WP specimen ID
and each value is another assoc array where
key is meta_key and value is meta_value
*/
add_action( 'wp_ajax_findSpecimen', 'findSpecimen_callback' );
function findSpecimen_callback() {

    $dat = $_GET['dat'];
    $cols = $_GET['cols'];

    global $wpdb;

    # generate prepare statement
    $query = "SELECT post_id FROM $wpdb->postmeta"; // get initial list of IDs - needed if filtering for finished/unfinished
    $rules = build_prep_statement($dat);
    if (count($rules[0]) && $rules[0] != '') $query .= " WHERE" . $rules[0];
    $prep = $wpdb->prepare($query, $rules[1]);

    # run query - array of $ids
    $ids = $wpdb->get_col($prep);

    # run second query on joined table, now that we have list of required IDs
    if (count($ids)) {
        $query = "SELECT ID, meta_key, meta_value FROM $wpdb->posts a LEFT JOIN $wpdb->postmeta b on a.ID = b.post_id WHERE post_type = 'specimen' AND post_status = 'publish' AND post_id in (" . implode(',',$ids) . ")";
        $ids = $wpdb->get_results($query, ARRAY_A);
    

        # reformat results into table form
        # where each row is a specimen
        $data = [];
        foreach ($ids as $obj) {
            $id = $obj['ID'];
            $meta_key = $obj['meta_key'];
            $meta_value = $obj['meta_value'];

            if (in_array($meta_key, $cols) ) {
                if ($data[$id]) {
                    $data[$id][$meta_key] = $meta_value;
                } else {
                    $data[$id] = array($meta_key => $meta_value);
                }
            }
        }
        echo json_encode( array('dat' => $data, 'rules' => $rules, 'prep' => $prep , 'wp' => $wpdb) );
    } else {
        echo json_encode( array('rules' => $rules, 'prep' => $prep , 'wp' => $wpdb, 'query' => $query) );
    }

    wp_die();
}


/* Recrusive function to generate WHERE clause

The jQuery QueryBuilder script generates
a JSON of rules (http://querybuilder.js.org/demo.html),
this must be parsed in a recursive manner.

This function will recursively generate
the SQL/args part of the prepared statment
see https://developer.wordpress.org/reference/classes/wpdb/prepare/

Should be used in conjuction with build_prep_values

Parameters:
-----------
- $rules : obj
           JSON of rules, http://querybuilder.js.org/demo.html

Returns:
--------
array where:
[0]: string formatted for prepared statement
[1]: build_prep_statement($tmp)
*/
function build_prep_statement($rules) {

    $cond = $rules['condition'];
    $rule_arr = $rules['rules'];

    $rule = [];
    $count = 0;
    foreach ($rule_arr as $tmp) {
        if ( isset($tmp['condition'] )) {
            $recur = build_prep_statement($tmp);
            $query = $rule[0] . " " . $cond . " (" . $recur[0] . ")";
            $args = array_merge($rule[1], $recur[1] );
        } else {
            if (!($tmp['field'] == 'status' && $tmp['value'] == 'all')) { // don't generate WHERE filter when requesting all specimens

                $compare = "= '%s'";

                // if selecting samples with issue, need to search inputIssue key
                // and make query meta_value like '%'
                if ($tmp['field'] == 'status' && $tmp['value'] == 'issue') { 
                    $tmp['field'] = 'inputIssue';
                    $tmp['value'] = '';
                    $compare = "!= '%s'";
                } else if ($tmp['field'] == 'downloaded') {
                    if ($tmp['value'] == "1") { // downloaded specimens
                        $compare = "!= '%s'";
                    }
                    $tmp['value'] = '';
                }


                if ($count) {
                    $query = $rule[0] . " " . $cond . " (meta_key = '%s' and meta_value $compare)";
                    $args = array_merge($rule[1], array($tmp['field'], $tmp['value']));
                } else {
                    $query = " (meta_key = '%s' and meta_value $compare)";
                    $args = array($tmp['field'], $tmp['value']);
                }
                $count += 1;
            }
        }
        $rule = array($query, $args); 
    }

    return $rule;

}





/* Function called by AJAX to load/update specimen data

If data is provided with function call, supplied data will
also be used to update the current specimen (the one defined
by the passed value 'id')

Parameters:
-----------
- $_GET['id'] : int
                WP defined ID for current specimen; if 'dat'
                is provided, this will be used to update the 
                given specimen with this ID.
- $_GET['nav'] : str
                 one of 'current', 'next' or 'previous'
- $_GET['dat'] : obj
                 form data (will be null if on first load of page)
                 used to update specimen defined by 'id'
- $_GET['view'] : str
                  specimen status to view, must be one of 'all', 
                  'finished','unfinished','issue'
Returns:
--------
json encoded array of metadata associated with speciment (if
it exists) otherwise returns false

*/
add_action( 'wp_ajax_loadSpecimen', 'loadSpecimen_callback' );
function loadSpecimen_callback() {

    global $wpdb;
    $id = intval($_GET['id']);
    $nav = $_GET['nav'];
    $dat_set = $_GET['dat'];

    if ( !in_array( $nav, array('next','previous','current') ) ) return;


    // check if this 'finishes' the specimen
    if ( $dat_set['inputCollector'] != '' && $dat_set['inputNumber'] != '' && $dat_set['inputIssue'] == '' ) {
        $dat_set['status'] = 'finished';
    } else if ( $nav != 'current' ) {
        $dat_set['status'] = 'unfinished';
    }

    // update specimen with incoming data
    if ($dat_set) spnov_update_specimen($id, $dat_set);


    // filter specimens
    $filter = '';
    if ($_GET['status'] == 'finished') {
        $filter = " AND meta_key = 'status' and meta_value = 'finished'";
    } elseif ($_GET['status'] == 'issue') {
        $filter = " AND meta_key = 'inputIssue'";
    } elseif ($_GET['status'] == 'unfinished') {
        $filter = " AND meta_key = 'status' and meta_value = 'unfinished'";
    }



    // check max/min specimen ID
    $row = $wpdb->get_row( "SELECT ID, min(ID) as min, max(ID) as max FROM $wpdb->posts a LEFT JOIN $wpdb->postmeta b on a.ID = b.post_id WHERE post_type = 'specimen' AND post_status = 'publish' $filter ORDER BY ID LIMIT 1" );
    $min = $row->min; // min specimen ID
    $max = $row->max; // max specimen ID

    // if ID is 0, the first specimen is loaded
    if (!$id) {
        $id = $row->ID;
    }

    // look up next/previous ID if needed
    if ($nav == 'previous') {
        if ($id == $min || $min == $max) { // wrap to last ID
            $id = $max;
        } else {
            $id = $wpdb->get_var( "SELECT ID FROM $wpdb->posts a LEFT JOIN $wpdb->postmeta b on a.ID = b.post_id WHERE post_type = 'specimen' and post_status = 'publish' and ID < $id $filter ORDER BY ID DESC LIMIT 1" );
        }
    } elseif ($nav == 'next') {
        if ($id == $max || $min == $max) { // wrap to first ID
            $id = $min;
        } else {
            $id = $wpdb->get_var( "SELECT ID FROM $wpdb->posts a LEFT JOIN $wpdb->postmeta b on a.ID = b.post_id WHERE post_type = 'specimen' and post_status = 'publish' and ID > $id $filter ORDER BY ID LIMIT 1" );
        }
    }

    $dat = get_post_meta( $id );

    if ( count($dat) ){

        // reformat data a bit before sending
        $tmp = array('id' => $id, 'dat_set' => $dat_set);
        foreach($dat as $key => $val) {
            $tmp[$key] = $val[0];
        }

        echo json_encode( $tmp );
    } else {
        echo json_encode( false );
    }

    wp_die(); // this is required to terminate immediately and return a proper response
}





/**
  * Updates post meta for a post. It also automatically deletes or adds the value to field_name if specified
  *
  * @access     protected
  * @param      integer     The post ID for the post we're updating
  * @param      string      The field we're updating/adding/deleting
  * @param      string      [Optional] The value to update/add for field_name. If left blank, data will be deleted.
  * @return     update wp_err
  */
function spnov_update_specimen( $post_id, $dat ) {

    spnov_update_history($post_id);

    foreach($dat as $field_name => $value) {

        $value = sanitize_text_field($value); // sanitize

        if ( ! get_post_meta( $post_id, $field_name ) )
        {
            $status = add_post_meta( $post_id, $field_name, $value );
        }
        else
        {
            $status = update_post_meta( $post_id, $field_name, $value );
        }
    }
    return $status;
}




/* Update history meta_key for specimen

Will add a timestamp and the user id to the
history array of the specimen

Parameters:
----------
- $id : int
        WP id associated with specimen

*/
function spnov_update_history( $id ) {

    $history = unserialize(get_post_meta( $id, 'history' ));
    if ( !is_array($history) ) {
        $history = array( time() => get_current_user_id() );
    } else {
        $history[time()] = get_current_user_id();
    }

    update_post_meta( $id, 'history', $history );
}







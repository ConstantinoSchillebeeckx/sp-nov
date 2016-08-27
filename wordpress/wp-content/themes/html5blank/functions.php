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
    add_image_size('large', 700, '', true); // Large Thumbnail
    add_image_size('medium', 250, '', true); // Medium Thumbnail
    add_image_size('small', 120, '', true); // Small Thumbnail
    add_image_size('custom-size', 700, 200, true); // Custom Thumbnail Size call using the_post_thumbnail('custom-size');

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
    if (is_page('classify') || is_page('upload') ) {
        // Custom scripts
        wp_enqueue_script('spnov_scripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), '1.0.0');
        wp_localize_script( 'spnov_scripts', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) ); // required to do AJAX!

        wp_register_script('autocomplete', get_template_directory_uri() . '/js/lib/jquery.autocomplete.min.js', array('jquery'), '1.2.26');
        wp_enqueue_script('autocomplete');

        wp_enqueue_style('autocomplete_css', get_template_directory_uri() . '/css/jquery.autocomplete.css', array(), '1.2.26');
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
            'post_author'   => sanitize_user($current_user->ID),
            'post_title'    => implode(', ', $imgs),
            'post_status'   => 'publish',
        );

        // Insert the post into the database
        $post_id = wp_insert_post( $my_post );
        if ($post_id != 0) { // if successfully added specimen, update the metadata

            // add array of associated images to specimen
            if (!add_post_meta( $post_id, 'imgs', $imgs )) {
                return false; // if error
            }

        } else {
            return false;
        }

    }

    return true;

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
        if (spnov_add_specimen($json)) {
            echo sprintf('<p class="lead">Great! %s speciments were properly uploaded.', count($json) );
        } else {
            echo '<p class="lead">Some sort of error occurred when adding a specimen to the databse...</p>';
        }
    } else {
        echo '<p class="lead">Something went wrong, please make sure file is JSON formatted and try again.</p>';
    }

}













/* Function called by AJAX to load speciment data from DB

Parameters:
-----------
- $_GET['id'] : int
                WP defined ID for specimen
- $_GET['nav'] : str
                 one of 'current', 'next' or 'previous'
- $_GET['dat'] : obj
                 form data (will be null if on first load of page)
Returns:
--------
json encoded array of metadata associated with speciment (if
it exists) otherwise returns false

*/
add_action( 'wp_ajax_loadSpecimen', 'loadSpecimen_callback' );
function loadSpecimen_callback() {

    global $wpdb;
    $id = $_GET['id'];
    $nav = $_GET['nav'];
    $dat_set = $_GET['dat'];

    if ($dat_set) spnov_update_specimen($id, $dat_set);

    // check max/min specimen ID
    $row = $wpdb->get_row( "SELECT ID, min(ID) as min, max(ID) as max FROM $wpdb->posts WHERE post_type = 'specimen' AND post_status = 'publish' ORDER BY ID LIMIT 1" );
    $min = $row->min; // min specimen ID
    $max = $row->max; // max specimen ID

    // if ID is 0, the first specimen is loaded
    if (!$id) {
        $id = $row->ID;
    }

    // look up next/previous ID if needed
    if ($nav == 'previous') {
        if ($id == $min) { // wrap to last ID
            $id = $max;
        } else {
            $id = $wpdb->get_var( "SELECT ID FROM $wpdb->posts where post_type = 'specimen' and post_status = 'publish' and ID < $id ORDER BY ID DESC LIMIT 1" );
        }
    } elseif ($nav == 'next') {
        if ($id == $max) { // wrap to first ID
            $id = $min;
        } else {
            $id = $wpdb->get_var( "SELECT ID FROM $wpdb->posts where post_type = 'specimen' and post_status = 'publish' and ID > $id ORDER BY ID LIMIT 1" );
        }
    }

    $dat = get_post_meta( $id );

    if ( count($dat) ){

        // reformat data a bit before sending
        $tmp = array('id' => $id);
        foreach($dat as $key => $val) {
            if (!unserialize($val[0])) {
                $tmp[$key] = $val[0]; // just pass regular string if unserialize fails
            } else {
                $tmp[$key] = unserialize($val[0]);
            }
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
        if ( empty( $value ) OR ! $value )
        {
            $status = delete_post_meta( $post_id, $field_name );
        }
        elseif ( ! get_post_meta( $post_id, $field_name ) )
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

    $history = get_post_meta( $post_id, 'history' );
    if ( !$history ) {
        $history = array( time() => get_current_user_id() );
    } else {
        $history[time()] = get_current_user_id();
    }

    update_post_meta( $id, 'history', $history );
}







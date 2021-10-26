<?php

/**
 * Do not edit anything in this file unless you know what you're doing
 */

use Roots\Sage\Config;
use Roots\Sage\Container;

/**
 * Helper function for prettying up errors
 * @param string $message
 * @param string $subtitle
 * @param string $title
 */
$sage_error = function ($message, $subtitle = '', $title = '') {
    $title = $title ?: __('Sage &rsaquo; Error', 'sage');
    $footer = '<a href="https://roots.io/sage/docs/">roots.io/sage/docs/</a>';
    $message = "<h1>{$title}<br><small>{$subtitle}</small></h1><p>{$message}</p><p>{$footer}</p>";
    wp_die($message, $title);
};

/**
 * Ensure compatible version of PHP is used
 */
if (version_compare('7.1', phpversion(), '>=')) {
    $sage_error(__('You must be using PHP 7.1 or greater.', 'sage'), __('Invalid PHP version', 'sage'));
}

/**
 * Ensure compatible version of WordPress is used
 */
if (version_compare('4.7.0', get_bloginfo('version'), '>=')) {
    $sage_error(__('You must be using WordPress 4.7.0 or greater.', 'sage'), __('Invalid WordPress version', 'sage'));
}

/**
 * Ensure dependencies are loaded
 */
if (!class_exists('Roots\\Sage\\Container')) {
    if (!file_exists($composer = __DIR__.'/../vendor/autoload.php')) {
        $sage_error(
            __('You must run <code>composer install</code> from the Sage directory.', 'sage'),
            __('Autoloader not found.', 'sage')
        );
    }
    require_once $composer;
}

/**
 * Sage required files
 *
 * The mapped array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 */
array_map(function ($file) use ($sage_error) {
    $file = "../app/{$file}.php";
    if (!locate_template($file, true, true)) {
        $sage_error(sprintf(__('Error locating <code>%s</code> for inclusion.', 'sage'), $file), 'File not found');
    }
}, ['helpers', 'setup', 'filters', 'admin']);

/**
 * Here's what's happening with these hooks:
 * 1. WordPress initially detects theme in themes/sage/resources
 * 2. Upon activation, we tell WordPress that the theme is actually in themes/sage/resources/views
 * 3. When we call get_template_directory() or get_template_directory_uri(), we point it back to themes/sage/resources
 *
 * We do this so that the Template Hierarchy will look in themes/sage/resources/views for core WordPress themes
 * But functions.php, style.css, and index.php are all still located in themes/sage/resources
 *
 * This is not compatible with the WordPress Customizer theme preview prior to theme activation
 *
 * get_template_directory()   -> /srv/www/example.com/current/web/app/themes/sage/resources
 * get_stylesheet_directory() -> /srv/www/example.com/current/web/app/themes/sage/resources
 * locate_template()
 * ├── STYLESHEETPATH         -> /srv/www/example.com/current/web/app/themes/sage/resources/views
 * └── TEMPLATEPATH           -> /srv/www/example.com/current/web/app/themes/sage/resources
 */
array_map(
    'add_filter',
    ['theme_file_path', 'theme_file_uri', 'parent_theme_file_path', 'parent_theme_file_uri'],
    array_fill(0, 4, 'dirname')
);
Container::getInstance()
    ->bindIf('config', function () {
        return new Config([
            'assets' => require dirname(__DIR__).'/config/assets.php',
            'theme' => require dirname(__DIR__).'/config/theme.php',
            'view' => require dirname(__DIR__).'/config/view.php',
        ]);
    }, true);

/**
 *  Remove Default Post Type 
 */
 
//Remove from Quick Draft
add_action( 'wp_dashboard_setup', 'remove_draft_widget', 999 );
 
function remove_draft_widget(){
    remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
}
//Remove from +New Post in Admin Bar
add_action( 'admin_bar_menu', 'remove_default_post_type_menu_bar', 999 );
 
function remove_default_post_type_menu_bar( $wp_admin_bar ) {
    $wp_admin_bar->remove_node( 'new-post' );
}
 
//Remove from the Side Menu
add_action( 'admin_menu', 'remove_default_post_type' );
 
function remove_default_post_type() {
    remove_menu_page( 'edit.php' );
}

// Hide Admin bar to subscriber
add_action('set_current_user', 'cc_hide_admin_bar');
function cc_hide_admin_bar() {
    if (!current_user_can('edit_posts')) {
        show_admin_bar(false);
    }
}

// Don't run BarbaJS when admin user is logged-in
function ajax_check_user_is_admin() {
    $user = wp_get_current_user();
    echo ( in_array( 'subscriber', (array) $user->roles ) && is_user_logged_in() || !is_user_logged_in()) ? true : false;
    die();
}

// Hide CPT Notice
add_action('admin_head', 'hide_cpt_notice');

function hide_cpt_notice() {
  echo '<style>
    .cpt-notice {
      display: none;
    } 
  </style>';
}

add_action('wp_ajax_is_user_admin', 'ajax_check_user_is_admin');
add_action('wp_ajax_nopriv_is_user_admin', 'ajax_check_user_is_admin');

// Ajax load custom post content
add_action('init', function(){    
    add_rewrite_tag('%offset%','([0-9]+)');
    add_rewrite_tag('%post_type%','([^&]+)');
    add_rewrite_tag('%per_page%','([0-9]+)');
    add_rewrite_rule('content-api/([^&]+)/([0-9]+)/([0-9]+)/?', 'index.php?post_type=$matches[1]&offset=$matches[2]&per_page=$matches[3]', 'top');
});

add_action('template_redirect', function(){
    global $wp_query;
    $offset = $wp_query->get('offset');
    $per_page = $wp_query->get('per_page');
    $post_type = $wp_query->get('post_type');
    $output = '';

    if(!empty($offset) && !empty($post_type)){
        // Create Args for get posts
        $args = [
            'post_type' => $post_type,
            'posts_per_page' => $per_page,
            'order_by' => 'DESC',
            'offset' => $offset
        ];

        // Get custom posts
        $posts = get_posts($args);
        
        ob_start();
        foreach($posts as $post) {
            switch($post_type) {
                case 'news':
                    $output .= App::get_news_template($post);
                break;
                case 'gallery':
                    $output .= App::get_gallery_template($post);
                break;
                case 'shop-product':
                    $output .= App::get_shop_template($post);
                break;
                case 'field-report':
                    $output .= App::get_field_report_template($post);
                break;
            }            
        }
        ob_get_clean();

        wp_send_json_success($output);
    }
});
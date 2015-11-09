<?php


// Helpers
require_once 'base/helpers.php';
// FormBuilder
require_once 'base/form-builder.php';

// Shortcodes
require_once 'base/shortcodes.php';

//WPML
add_action('after_setup_theme', 'my_theme_setup');
function my_theme_setup(){
    load_theme_textdomain('neurotracker', get_template_directory() . '/languages');
}

//add class to excerpt
add_filter( "the_excerpt", "add_class_to_excerpt" );
function add_class_to_excerpt( $excerpt ) {
    return str_replace('<p', '<p class="excerpt"', $excerpt);
}


function features_after_setup_theme()
{
    // Menus
    register_nav_menus(
        array(
            'header-menu' => __('Header Menu'),
            'footer-menu' => __('Footer Menu'),
            'mobile-menu' => __('Mobile Menu'),
        )
    );

    // Register Custom Navigation Walker
    if (!class_exists('wp_bootstrap_navwalker')) {
        require_once('vendor/bootstrap-navwalker/wp_bootstrap_navwalker.php');
    }

    // Thumbnails
    add_theme_support('post-thumbnails');
//    Image Size Names: left out for lack of any actual use
//    add_image_size('300x300', 300, 300, true);
//    add_image_size('450x450', 450, 450, true);
//    add_filter('image_size_names_choose', 'image_size_names');
//    function image_size_names($sizes)
//    {
//        return array_merge($sizes, array(
//            '300x300' => __('Thumbnail Medium'),
//            '450x450' => __('Thumbnail Large'),
//        ));
//    }
}
add_action('after_setup_theme', 'features_after_setup_theme');


function features_init()
{
    // Custom Meta Boxes
    if (!class_exists('CMB2_Bootstrap_208')) {
        require_once('vendor/custom-meta-boxes/init.php');
        if ( ! function_exists( 'cmb2_attached_posts_fields_render' ) ) {
            require_once "vendor/attached-posts/attached-posts.php";
            //require_once "base/attached-posts.php";
        }
        require_once 'base/custom-meta-boxes.php';
        //require_once 'base/admin-option.php';
        add_filter('cmb2_meta_boxes', 'set_custom_meta_boxes');
        remove_templates_support();
    }

    if (!class_exists('Tax_Meta_Class')) {
        require_once("vendor/Tax-meta-class/Tax-meta-class.php");
        require_once("base/custom-tax-meta.php");
    }

    // Custom Post Types
    if (!class_exists('CPT')) {
        require_once('vendor/custom-post-types/CPT.php');
        require_once 'base/custom-post-types.php';
        set_custom_post_types();
    }

    // Media Taxonomies
    register_taxonomy_for_object_type('category', 'attachment');
    register_taxonomy_for_object_type('post_tag', 'attachment');
}
add_action('init', 'features_init');


function features_get_header()
{
	// Remove Admin-Bar
	add_filter( 'show_admin_bar', '__return_false' );
	remove_action('wp_head', '_admin_bar_bump_cb');
}
add_action('get_header', 'features_get_header');


function features_wp_enqueue_scripts()
{

    //jquery
    wp_enqueue_script('jquery','http://code.jquery.com/jquery-1.11.3.min.js');
    //  Custom Stylesheet
    wp_register_style('custom_stylesheet', get_template_directory_uri() . '/css/base.css');
    wp_enqueue_style('custom_stylesheet');

    // Google Fonts
    // wp_register_style('google_font_roboto', 'http://fonts.googleapis.com/css?family=Roboto:400,300,300italic,400italic,500,500italic,700,700italic,900,900italic');
    // wp_enqueue_style('google_font_roboto');
    // wp_register_style('google_font_roboto_slab', 'http://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700');
    // wp_enqueue_style('google_font_roboto_slab');
    // wp_register_style('google_font_roboto_mono', 'http://fonts.googleapis.com/css?family=Roboto+Mono:400,300,300italic,400italic,700,700italic');
    // wp_enqueue_style('google_font_roboto_mono');

    // Scripts
    require_once 'base/scripts.php';
    load_scripts();

}
add_action('wp_enqueue_scripts', 'features_wp_enqueue_scripts');
function admin_script(){
    //admin
    if(is_admin()){
        wp_enqueue_script('custom_admin_script',get_template_directory_uri().'/scripts/admin/admin_script.js', array('jquery'));
    }
}
add_action('wp_enqueue_scripts', 'features_wp_enqueue_scripts');
add_action( 'admin_enqueue_scripts', 'admin_script' );

function templateFilter() {
    if (isset($_GET['post'])) {
        $id = $_GET['post'];
        $template = get_post_meta($id, '_wp_page_template', true);
        $dontShowEditor = array(
            //'tpl-product-research-studies.php',
        );
        if(in_array($template, $dontShowEditor) || in_array($id, $dontShowEditor)){
            remove_post_type_support( 'page', 'editor' );
        }
    }
}
add_action('init', 'templateFilter');


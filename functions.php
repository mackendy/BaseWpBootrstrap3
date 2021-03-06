<?php

require_once 'includes/base.php';

// HELPERS ---------------------------------------------------------------

/** Favicon generator online tool :: http://www.favicon-generator.org/ **/
function set_favicons($path)
{
    echo '<link rel="apple-touch-icon" sizes="57x57" href="'.$path.'apple-icon-57x57.png">';
    echo '<link rel="apple-touch-icon" sizes="60x60" href="'.$path.'apple-icon-60x60.png">';
    echo '<link rel="apple-touch-icon" sizes="72x72" href="'.$path.'apple-icon-72x72.png">';
    echo '<link rel="apple-touch-icon" sizes="76x76" href="'.$path.'apple-icon-76x76.png">';
    echo '<link rel="apple-touch-icon" sizes="114x114" href="'.$path.'apple-icon-114x114.png">';
    echo '<link rel="apple-touch-icon" sizes="120x120" href="'.$path.'apple-icon-120x120.png">';
    echo '<link rel="apple-touch-icon" sizes="144x144" href="'.$path.'apple-icon-144x144.png">';
    echo '<link rel="apple-touch-icon" sizes="152x152" href="'.$path.'apple-icon-152x152.png">';
    echo '<link rel="apple-touch-icon" sizes="180x180" href="'.$path.'apple-icon-180x180.png">';
    echo '<link rel="icon" type="image/png" sizes="192x192"  href="'.$path.'android-icon-192x192.png">';
    echo '<link rel="icon" type="image/png" sizes="32x32" href="'.$path.'favicon-32x32.png">';
    echo '<link rel="icon" type="image/png" sizes="96x96" href="'.$path.'favicon-96x96.png">';
    echo '<link rel="icon" type="image/png" sizes="16x16" href="'.$path.'favicon-16x16.png">';
    echo '<link rel="manifest" href="'.$path.'manifest.json">';
    echo '<meta name="msapplication-TileColor" content="#ffffff">';
    echo '<meta name="msapplication-TileImage" content="'.$path.'ms-icon-144x144.png">';
    echo '<meta name="theme-color" content="#ffffff">';
}

class Walker_Foundation_Topbar extends Walker_Nav_Menu {
    function start_lvl(&$output, $depth = 0) {
        $output .= "<ul class=\"dropdown\">";

    }
}

// security -----------------------------------------------------------------

//<files readme.html>
//order allow,deny
//        deny from all
//</files>

add_filter( 'auto_update_plugin', '__return_false' );
add_filter( 'auto_update_theme', '__return_false' );
add_filter( 'automatic_updater_disabled', '__return_false' );
add_filter( 'auto_update_core', '__return_false' );
remove_action('wp_head', 'wp_generator');


// THEME -----------------------------------------------------------------



function my_nav_wrap() {
    // default value of 'items_wrap' is <ul id="%1$s" class="%2$s">%3$s</ul>'

    // open the <ul>, set 'menu_class' and 'menu_id' values
    $wrap  = '<ul id="%1$s" class="%2$s">';

    // get nav items as configured in /wp-admin/
    $wrap .= '%3$s';


    $wrap .= '</ul>';

    return $wrap;
}

function my_nav_wrap_wpml() {
    // default value of 'items_wrap' is <ul id="%1$s" class="%2$s">%3$s</ul>'

    // open the <ul>, set 'menu_class' and 'menu_id' values
    $wrap  = '<ul id="%1$s" class="%2$s">';

    // get nav items as configured in /wp-admin/
    $wrap .= '%3$s';

    $languages = icl_get_languages('skip_missing=0&orderby=code');
    $wrap .='<li class="text-uppercase">';
    foreach($languages as $l){
        foreach($languages as $l){
            if(!$l['active']) $langs[] = '<a href="'.$l['url'].'">'.$l['language_code'].'</a>';

        }
    }
    $wrap .=$langs[0];
    $wrap .='</li>';



    $wrap .= '</ul>';

    return $wrap;
}





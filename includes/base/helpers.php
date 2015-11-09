<?php

function get_prefix()
{
    $prefix = '_base_';
    return  $prefix;
}

function themeDomain(){
    return 'ls';
}

function get_lang_active($validateAgainst = false) {
    $activeLang = 'en';
    if(class_exists('SitePress')){
        global $sitepress;
        $activeLang = $sitepress->get_current_language();
    }

    if(!$validateAgainst){
        return $activeLang;
    }else{
        return ($activeLang == $validateAgainst);
    }
}

function set_html_content_type() {
    return 'text/html';
}

function get_attachment_id_from_src ($src) {
    global $wpdb;

    $reg = "/-[0-9]+x[0-9]+?.(jpg|jpeg|png|gif)$/i";

    $src1 = preg_replace($reg,'',$src);

    if($src1 != $src){
        $ext = pathinfo($src, PATHINFO_EXTENSION);
        $src = $src1 . '.' .$ext;
    }

    $query = "SELECT ID FROM {$wpdb->posts} WHERE guid='$src'";
    $id = $wpdb->get_var($query);

    return $id;
}

function cmb2_output_file_list_partenaire_logo( $file_list_meta_key, $img_size = 'medium' ) {

    // Get the list of files
    $files = nt_get_option( $file_list_meta_key );


    echo '<ul class="partenaire">';
    // Loop through them and output an image
    foreach ( (array) $files as $attachment_id => $attachment_url ) {
        $link = get_post_meta( $attachment_id,get_prefix().'attachment_link',true );
        echo '<li class="file-list-image">';
        echo '<a href="'.$link.'">';
        echo wp_get_attachment_image( $attachment_id, $img_size );
        echo '</a>';

        echo '</li>';
    }
    echo '</ul>';
}

function cmb2_output_file_list_partenaire_logo2( $file_list_meta_key, $img_size = 'medium' ) {

    // Get the list of files
    $files = get_post_meta( get_the_ID(), $file_list_meta_key, 1 );


    echo '<ul class="partenaire">';
    // Loop through them and output an image
    foreach ( (array) $files as $attachment_id => $attachment_url ) {
        $link = get_post_meta( $attachment_id,get_prefix().'attachment_link',true );
        echo '<li class="file-list-image">';
        echo '<a href="'.$link.'">';
        echo wp_get_attachment_image( $attachment_id, $img_size );
        echo '</a>';

        echo '</li>';
    }
    echo '</ul>';
}

function gallery_realisation( $file_list_meta_key, $img_size = 'medium' ) {

    // Get the list of files
    $files = get_post_meta( get_the_ID(), $file_list_meta_key, 1 );
    if($files != 0 ):
        echo"<div class='relative'>";
        echo "<div class='gal-nav'><div class='prev pointer'></div><div class='next pointer'></div></div>";
        echo '<ul class="gallery_real">';
        // Loop through them and output an image
        foreach ( (array) $files as $attachment_id => $attachment_url ) {
            //$link = get_post_meta( $attachment_id,get_prefix().'attachment_link',true );
            echo '<li class="text-center fixheight ">';
            // echo '<a href="'.$link.'">';
            echo wp_get_attachment_image( $attachment_id, $img_size,'',array('class'=>'image-height') );
            //echo '</a>';

            echo '</li>';
        }
        echo '</ul>';
        echo"</div>";
    endif;
}

function pagination($pages = '', $range = 4)
{
    $showitems = ($range * 2)+1;

    global $paged;

    if(empty($paged)) $paged = 1;

    if($pages == '')
    {
        global $wp_query;
        $pages = $wp_query->max_num_pages;
        if(!$pages)
        {
            $pages = 1;
        }
    }

    if(1 != $pages)
    {

        echo "<div class=\"pagination pull-right\">";
//        <span>Page ".$paged." of ".$pages."</span>
        if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo; First</a>";
        if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo; Previous</a>";

        for ($i=1; $i <= $pages; $i++)
        {
            if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
            {
                echo ($paged == $i)? "<span class=\"current\">".$i."</span>":"<a href='".get_pagenum_link($i)."' class=\"inactive\">".$i."</a>";
            }
        }

        if ($paged < $pages && $showitems < $pages) echo "<a href=\"".get_pagenum_link($paged + 1)."\">Next &rsaquo;</a>";
        if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>Last &raquo;</a>";
        echo "</div>\n";
    }
}

function pagination2()
{

    if (is_singular())
        return;

    global $wp_query;

    /** Stop execution if there's only 1 page */
    if ($wp_query->max_num_pages <= 1)
        return;

    $paged = get_query_var('paged') ? absint(get_query_var('paged')) : 1;
    $max = intval($wp_query->max_num_pages);

    /** Add current page to the array */
    if ($paged >= 1)
        $links[] = $paged;

    /** Add the pages around the current page to the array */
    if ($paged >= 3) {
        $links[] = $paged - 1;
        $links[] = $paged - 2;
    }

    if (($paged + 2) <= $max) {
        $links[] = $paged + 2;
        $links[] = $paged + 1;
    }

    echo '<div class="navigation"><ul>' . "\n";

    /** Previous Post Link */
    if (get_previous_posts_link())
        printf('<li>%s</li>' . "\n", get_previous_posts_link());

    /** Link to first page, plus ellipses if necessary */
    if (!in_array(1, $links)) {
        $class = 1 == $paged ? ' class="active"' : '';

        printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link(1)), '1');

        if (!in_array(2, $links))
            echo '<li>…</li>';
    }

    /** Link to current page, plus 2 pages in either direction if necessary */
    sort($links);
    foreach ((array)$links as $link) {
        $class = $paged == $link ? ' class="active"' : '';
        printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link($link)), $link);
    }

    /** Link to last page, plus ellipses if necessary */
    if (!in_array($max, $links)) {
        if (!in_array($max - 1, $links))
            echo '<li>…</li>' . "\n";

        $class = $paged == $max ? ' class="active"' : '';
        printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link($max)), $max);
    }

    /** Next Post Link */
    if (get_next_posts_link())
        printf('<li>%s</li>' . "\n", get_next_posts_link());

    echo '</ul></div>' . "\n";

}
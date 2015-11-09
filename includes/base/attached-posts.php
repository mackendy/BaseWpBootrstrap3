<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 15-09-30
 * Time: 1:43 PM
 */
function cmb2_attached_posts_field_metaboxes() {
    /*
    *
    * Markets
    *
    */


    $market_content = new_cmb2_box( array(
        'id' => 'market_content',
        'title' => 'Contant',
        'object_types' => array('markets_categories', ),
        //'show_on'       => array( 'key' => 'page-template', 'value' => array('tpl-quality-policy.php') ),
        'context' => 'normal',
        'priority' => 'high',
        'show_names' => true,
    ) );
    $market_content->add_field( array(
        'name' => __( 'text top','plastifab' ),
        'id' => $prefix . 'top_text',
        'sanitization_cb' => false,
        'type' => 'wysiwyg',
    ));
    $group_field_id = $market_content->add_field( array(
        'id'          => 'wiki_test_repeat_group',
        'type'        => 'group',
        'description' => __( 'Generates reusable form entries', 'cmb' ),
        'options'     => array(
            'group_title'   => __( 'Entry {#}', 'cmb' ), // since version 1.1.4, {#} gets replaced by row number
            'add_button'    => __( 'Add Another Entry', 'cmb' ),
            'remove_button' => __( 'Remove Entry', 'cmb' ),
            'sortable'      => true, // beta
        )
    ) );

    $market_content->add_group_field( $group_field_id, array(
        'name' => 'Entry Title',
        'id'   => 'title',
        'type' => 'text',
         //'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
    ) );
    $market_content->add_group_field( $group_field_id, array(
        'name' => 'Entry Title',
        'id'   => 'contant',
        'type' => 'wysiwyg',
        //'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
    ) );




    $market_attached_to_case_studies = new_cmb2_box( array(
        'id'           => 'case_studies',
        'title'        => __( 'Attached Case studies', 'plastifab' ),
        'object_types' => array( 'markets_categories' ), // Post type
        'context'      => 'normal',
        'priority'     => 'high',
        'show_names'   => false, // Show field names on the left
    ) );
    $market_attached_to_case_studies->add_field( array(
        'name'    => __( 'Attached case studies', 'plastifab' ),
        //'desc'    => __( 'Drag posts from the left column to the right column to attach them to this page.<br />You may rearrange the order of the posts in the right column by dragging and dropping.', 'cmb2' ),
        'id'      => 'attached_case_studies',
        'type'    => 'custom_attached_posts',
        'options' => array(
            'show_thumbnails' => true, // Show thumbnails on the left
            'filter_boxes'    => true, // Show a text box for filtering the results
            'query_args'      => array(
                'posts_per_page' => 10,
                'post_type' => 'case_studies',
                'orderby' => 'menu_order',

            ), // override the get_posts args
        )
    ) );
    $market_width = new_cmb2_box( array(
        'id' => 'market_width',
        'title' => 'column width',
        'object_types' => array('markets_categories', ),
        //'show_on'       => array( 'key' => 'page-template', 'value' => array('tpl-quality-policy.php') ),
        'context' => 'normal',
        'priority' => 'high',
        'show_names' => true,
    ) );
    $market_width->add_field( array(
        'name' => __( 'background_image','plastifab' ),
        'id' => $prefix . 'background_image',
        'sanitization_cb' => false,
        'type' => 'file',
    ));
    $market_width->add_field( array(
        'name'             => 'Column width',
        'id'               => 'column_width',
        'type'             => 'radio',
        'show_option_none' => false,
        'options'          => array(
            'full' => __( 'full', 'cmb' ),
            'half'   => __( 'half', 'cmb' ),
            // 'none'     => __( 'Option Three', 'cmb' ),
        ),
    ));

}
add_action( 'cmb2_init', 'cmb2_attached_posts_field_metaboxes' );
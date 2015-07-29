<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 27/07/15
 * Time: 12:16
 */

/*
* configure taxonomy custom fields
*/
$config = array(
    'id' => 'demo_meta_box',                         // meta box id, unique per meta box
    'title' => 'Demo Meta Box',                      // meta box title
    'pages' => array('category'),                    // taxonomy name, accept categories, post_tag and custom taxonomies
    'context' => 'normal',                           // where the meta box appear: normal (default), advanced, side; optional
    'fields' => array(),                             // list of meta fields (can be added by field arrays)
    'local_images' => false,                         // Use local or hosted images (meta box images for add/remove)
    'use_with_theme' => true,                        //change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
);


/*
* Initiate your taxonomy custom fields
*/
$my_meta = new Tax_Meta_Class($config,'/includes/vendor/Tax-meta-class');

/*
* Add fields
*/
$my_meta->addColor('nt_color_picker',array(
    'name'=> 'My color '
));

/*
* Don't Forget to Close up the meta box deceleration
*/
//Finish Taxonomy Extra fields Deceleration
$my_meta->Finish();


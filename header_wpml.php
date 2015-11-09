<!doctype html>
<!--[if lt IE 7 ]><html class="ie ie6 no-js" lang="en"><![endif]-->
<!--[if IE 7 ]><html class="ie ie7 no-js" lang="en"><![endif]-->
<!--[if IE 8 ]><html class="ie ie8 no-js" lang="en"><![endif]-->
<!--[if IE 9 ]><html class="ie ie9 no-js" lang="en"><![endif]-->
<!--[if gt IE 9]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<!-- the "no-js" class is for Modernizr. -->
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1"/>
    <title><?php bloginfo('name'); ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	<?php
    $favicon_path = get_template_directory_uri().'/images/favicon/';
    set_favicons($favicon_path);
    wp_head();
    ?>
    
</head>

<body <?php body_class( $class ); ?>>

	<header>

        <nav class="navbar navbar-inverse ">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?php echo icl_get_home_url() ?>"><?php echo get_bloginfo('name'); ?></a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-left">
                        <?php
                        $args = array(
                            'theme_location' => 'header-menu',
                            'depth'             => 2,
                            'container'         => 'div',
                            'container_class'   => 'collapse navbar-collapse',
                            'menu_class'        => 'nav navbar-nav',
                            'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
                            'walker'            => new wp_bootstrap_navwalker(),
                            'items_wrap' => my_nav_wrap_wpml(),
                        );
                        wp_nav_menu($args);
                        ?>
                    </ul>
                    <ul>
                        <?php $languages = icl_get_languages('skip_missing=0&orderby=code'); ; ?>
                        <li class="lang"><?php foreach($languages as $l){
                                foreach($languages as $l){
                                    if(!$l['active']) $langs[] = '<a href="'.$l['url'].'">'.$l['language_code'].'</a>';

                                }
                            }
                            echo $langs[0];  ?></li>
                        <li><?php //echo  get_permalink(icl_object_id(23, 'page', true)); ?></li>
                    </ul>
                </div>
            </div>
        </nav>

	</header>

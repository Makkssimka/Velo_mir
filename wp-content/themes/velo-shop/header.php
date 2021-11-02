<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>" />
    <?php wp_head(); ?>
</head>
<body>
    <div id="app">
        <?php get_template_part('blocks/all/notification') ?>
        <?php get_template_part('blocks/mobile_menu') ?>
        <div class="content">
            <?php get_template_part('blocks/top_sidebar') ?>
            <?php get_template_part('blocks/breadcrumbs') ?>

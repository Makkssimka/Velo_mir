<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>" />
    <?php wp_head(); ?>
</head>
<body>

<?php get_template_part('blocks/all/top-submenu') ?>
<?php get_template_part('blocks/all/top-header') ?>
<?php get_template_part('blocks/all/mobile-menu') ?>
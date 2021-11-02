<?php

global $wpdb;

?>
<?php get_header(); ?>

<div class="content-main home">
        <?php require_once "blocks/home/slider_home.php" ?>
        <?php require_once "blocks/home/alert_home.php" ?>
        <?php require_once "blocks/home/tabs_products.php" ?>
        <?php require_once "blocks/home/info-grey.php" ?>
        <?php require_once "blocks/home/article_home.php" ?>
</div>

<?php get_footer(); ?>
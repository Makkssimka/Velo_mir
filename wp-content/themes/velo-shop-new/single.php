<?php
global $post;
?>

<?php get_header(); ?>

<?php get_template_part('blocks/breadcrumbs') ?>

<div class="container content">
    <h1 class="h3"><?= $post->post_title; ?></h1>
    <div class="h6"><?= $post->post_excerpt; ?></div>

    <div>
        <?= $post->post_content; ?>
    </div>
</div>

<?php get_footer(); ?>
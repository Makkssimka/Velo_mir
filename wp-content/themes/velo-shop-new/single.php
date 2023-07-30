<?php
global $post;
$name_expert = get_option('name_expert');
?>

<?php get_header(); ?>

<div class="content-main article">
    <div class="container">
        <h1><?= $post->post_title; ?></h1>
        <div class="article-subheader"><?= $post->post_excerpt; ?></div>
        <div class="article-content">
            <div class="article-text">
                <?= $post->post_content; ?>
            </div>
            <div class="article-navbar">
                <?php expert_widget() ?>
                <div class="article-anchor-nav">
                    <p>Содержание:</p>
                    <ul class="anchor-list">

                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
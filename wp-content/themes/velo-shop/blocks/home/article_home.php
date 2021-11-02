<?php
$articles = get_posts(array(
    'category' => 80,
    'numberposts' => 6
));
?>

<div class="home-block">
    <div class="container">
        <h2>Полезные <span>статьи</span></h2>
        <p class="home-block-subheader">Мы подготовили для вас ряд статей про правильный выбор велосиредов. Приобретайте себе велосипед осмысленно.</p>
        <div class="home-list-article">
                <?php foreach ($articles as $key => $article): ?>
                    <?php $article_image = get_the_post_thumbnail_url($article->ID, 'full') ?>
                    <?php if($key % 2 == 0 ): ?>
                        <div class="column">
                        <a href="<?= get_post_permalink($article->ID) ?>" class="home-item-article" style="background-image: url('<?= $article_image ?>');">
                            <div class="home-desc-article">
                                <div class="home-desc-article-header">Как выбрать -</div>
                                <div class="home-desc-article-info"><?= $article->post_excerpt ?></div>
                            </div>
                            <div class="home-read-btn-option-article"></div>
                            <div class="home-read-btn-article">
                                <i class="las la-glasses"></i>
                            </div>
                        </a>
                    <?php else: ?>
                        <a href="<?= get_post_permalink($article->ID) ?>" class="home-item-article" style="background-image: url('<?= $article_image ?>');">
                            <div class="home-desc-article">
                                <div class="home-desc-article-header">Как выбрать -</div>
                                <div class="home-desc-article-info"><?= $article->post_excerpt ?></div>
                            </div>
                            <div class="home-read-btn-option-article"></div>
                            <div class="home-read-btn-article">
                                <i class="las la-glasses"></i>
                            </div>
                        </a>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
    </div>
</div>
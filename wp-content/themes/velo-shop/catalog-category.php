<?php

$children_category = $args['children_category'];
get_header();

?>

<main>
    <div class="container">
        <div class="sub-categories-list">
            <?php foreach ($children_category as $child) : ?>
                <?php sub_categories_widget($child) ?>
            <?php endforeach ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>
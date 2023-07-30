<div class="container">
    <div class="separator">
        <span>Новинки в магазине</span>
    </div>

    <div class="catalog-list catalog-list_5 mt-1">
        <?php foreach (getNewProduct() as $product) : ?>
            <?php get_template_part('blocks/all/product', null, ['product' => $product]) ?>
        <?php endforeach ?>
    </div>
</div>
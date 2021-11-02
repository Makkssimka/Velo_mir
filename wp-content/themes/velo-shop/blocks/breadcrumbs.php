<?php
global  $post;
global $product;

if (!is_front_page()): ?>
    <div class="breadcrumbs">
        <div class="container">
            <?php woocommerce_breadcrumb(['delimiter' => '<i class="las la-angle-right"></i>']); ?>
        </div>
    </div>
<?php endif; ?>
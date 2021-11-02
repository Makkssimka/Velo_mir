<?php

$count_page = $products_obj->max_num_pages;
$page_url = get_current_url();

?>

<div class="catalog-list-nav <?= $count_page == 1?'hidden-block':'' ?>">
    <ul>
        <?php if ($offset_page-1 > 0): ?>
        <li>
            <a href="<?= $page_url ?>">
                <i class="las la-angle-double-left"></i>
            </a>
        </li>
        <li>
            <a href="<?= $page_url.'?page_count='.($offset_page-1)?>">
                <i class="las la-angle-left"></i>
            </a>
        </li>
        <?php endif ?>
        <li>
            <form action="" method="get">
                <input type="text" name="page_count" value="<?= $offset_page ?>">
            </form>
        </li>
        <li class="nav-separator">из</li>
        <li>
            <a href="#" class="inactive"><?= $count_page ?></a>
        </li>
        <?php if ($offset_page+1 <= $count_page): ?>
        <li>
            <a href="<?= $page_url.'?page_count='.($offset_page+1)?>">
                <i class="las la-angle-right"></i>
            </a>
        </li>
        <li>
            <a href="<?= $page_url.'?page_count='.$count_page ?>">
                <i class="las la-angle-double-right"></i>
            </a>
        </li>
        <?php endif ?>
    </ul>
</div>
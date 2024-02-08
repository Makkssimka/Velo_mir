<?php

$products_obj = $args['products_obj'];
$offset_page = $args['offset_page'];

$count_page = $products_obj->max_num_pages;
$params = get_query_var('search') ? '?search=' . get_query_var('search') . '&' : '?';
$page_url = get_current_url() . $params;

?>

<?php if ($count_page != 1) : ?>
  <div class="page-nav mt-3">
      <a
        class="page-nav__arrow page-nav__arrow_mirror <?= $offset_page - 1 <= 0 ? 'disabled' : '' ?>"
        href="<?= $page_url ?>"
      >
          <img src="<?= get_asset_path('images/icons', 'r-d-arrow.svg') ?>" />
      </a>

      <a
        class="page-nav__arrow page-nav__arrow_mirror <?= $offset_page - 1 <= 0 ? 'disabled' : '' ?>"
        href="<?= $page_url.'page_count='.($offset_page - 1)?>"
      >
          <img src="<?= get_asset_path('images/icons', 'r-arrow.svg') ?>" />
      </a>

      <form action="" method="get">
          <input class="input page-nav__field" type="text" name="page_count" value="<?= $offset_page ?>">
      </form>

      <div class="text_sm">из</div>

      <div class="page-nav__counter">
          <?= $count_page ?>
      </div>

      <a
        class="page-nav__arrow <?= $offset_page + 1 > $count_page ? 'disabled' : '' ?>"
        href="<?= $page_url.'page_count='.($offset_page + 1)?>"
      >
          <img src="<?= get_asset_path('images/icons', 'r-arrow.svg') ?>" />
      </a>

      <a
        class="page-nav__arrow <?= $offset_page + 1 > $count_page ? 'disabled' : '' ?>"
        href="<?= $page_url.'page_count='.$count_page ?>"
      >
          <img src="<?= get_asset_path('images/icons', 'r-d-arrow.svg') ?>" />
      </a>
  </div>
<?php endif ?>
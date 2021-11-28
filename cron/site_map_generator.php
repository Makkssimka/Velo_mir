<?php

require_once "../wp-config.php";
require_once 'cron_write_log_function.php';

$site_map_folder = __DIR__ . '/../wp-sitemap/';
$products_map_folder = $site_map_folder. 'products/';

$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
if ($mysqli->connect_error) {
    write_log('Ошибка подключения к базе данных');
    die('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

write_log('Выполнена генерация карты сайта');

// Очищаем папки

clean($products_map_folder);

function clean ($folder) {
    foreach (glob($folder . '/*') as $file) {
        if (is_dir($file)) {
            clean($file);
            rmdir($file);
        } else {
            unlink($file);
        }
    }
}

if (!file_exists($products_map_folder)) {
   mkdir($products_map_folder);
}

createChildrenFolder(0, $products_map_folder, $mysqli);

/** Создаем папки категорий и подкатегорий товаров **/

function createChildrenFolder ($parent_id, $parent_folder, $mysqli) {
    $results = $mysqli
        ->query("
        SELECT velo_terms.term_id, name, slug FROM velo_term_taxonomy
        LEFT JOIN velo_terms ON velo_term_taxonomy.term_id = velo_terms.term_id
        WHERE velo_term_taxonomy.taxonomy = 'product_cat' AND velo_term_taxonomy.parent = " . $parent_id
    );

    if ($results->num_rows) {
        while ( $item = $results->fetch_object()) {

            // Пропускаем каталог на удаление
            if ($item->term_id == 4403) continue;

            $category_folder = $parent_folder . $item->slug . "/";
            createFoldersXML($parent_folder, $item);
            mkdir($category_folder);
            createChildrenFolder($item->term_id, $category_folder, $mysqli);
        }
    } else {
        createProductsXML($parent_folder, $parent_id, $mysqli);
    }
}

/** Создаем xml списка категрий и подкатегорий **/

function createFoldersXML ($parent_folder, $category) {
    $xml_style = $_SERVER['HTTP_HOST'] . '/wp-sitemap/style.xsl';
    $parent_folder_xml = $parent_folder . 'sitemap.xml';

    if (file_exists($parent_folder_xml)) {
        $doc = new DOMDocument();
        $doc->load($parent_folder_xml);

        $urlsetElement = $doc->getElementsByTagName('urlset')[0];
    } else {
        $doc = new DOMDocument('1.0', 'utf-8');

        $xslElement = $doc->createProcessingInstruction('xml-stylesheet', 'type="text/xsl" href="//' . $xml_style . '"');
        $doc->appendChild($xslElement);

        $urlsetElement = $doc->createElement('urlset');
        $urlsetElement->setAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
    }

    $doc->preserveWhiteSpace = false;
    $doc->formatOutput = true;

    $urlElement = $doc->createElement('url');
    $titleElement = $doc->createElement('title', $category->name . '.xml');
    $locElement = $doc->createElement('loc', $category->slug . '/sitemap.xml');
    $lastmodElement = $doc->createElement('lastmod', date('Y-m-d', time()));

    $urlElement->appendChild($titleElement);
    $urlElement->appendChild($locElement);
    $urlElement->appendChild($lastmodElement);

    $urlsetElement->appendChild($urlElement);
    $doc->appendChild($urlsetElement);

    $doc->save($parent_folder_xml);
}

/** Запрос на выборку товаров по категории и создание файла **/

function createProductsXML ($folder, $category_id, $mysqli) {
    $xml_style = $_SERVER['HTTP_HOST'] . '/wp-sitemap/style.xsl';
    $products = $mysqli
        ->query("
        SELECT velo_posts.ID, velo_posts.post_title, velo_posts.guid, velo_posts.post_modified  FROM velo_posts
        LEFT JOIN velo_term_relationships ON velo_posts.ID = velo_term_relationships.object_id
        LEFT JOIN velo_term_taxonomy ON velo_term_relationships.term_taxonomy_id = velo_term_taxonomy.term_taxonomy_id
        LEFT JOIN velo_postmeta ON velo_posts.id = velo_postmeta.post_id
        WHERE velo_term_taxonomy.term_id = " . $category_id . " AND velo_postmeta.meta_key = '_stock' AND velo_postmeta.meta_value <> 0
    ");

    $file_name = $folder . 'sitemap.xml';
    $doc = new DOMDocument('1.0', 'utf-8');
    $doc->preserveWhiteSpace = false;
    $doc->formatOutput = true;

    $xslElement = $doc->createProcessingInstruction('xml-stylesheet', 'type="text/xsl" href="//' . $xml_style . '"');
    $doc->appendChild($xslElement);

    $urlsetElement = $doc->createElement('urlset');
    $urlsetElement->setAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');

    while ( $product = $products->fetch_object()) {
        $urlElement = $doc->createElement('url');
        $titleElement = $doc->createElement('title', str_replace('&', '/', $product->post_title));
        $locElement = $doc->createElement('loc', $product->guid);
        $lastmodElement = $doc->createElement('lastmod', date('Y-m-d', strtotime($product->post_modified)));

        $urlElement->appendChild($titleElement);
        $urlElement->appendChild($locElement);
        $urlElement->appendChild($lastmodElement);

        $urlsetElement->appendChild($urlElement);
    }

    $doc->appendChild($urlsetElement);
    $doc->save($file_name);
}


$mysqli->close();
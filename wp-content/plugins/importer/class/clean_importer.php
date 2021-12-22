<?php


class IM_Clean
{
    public function getSiteProductsData(): array
    {
        global $wpdb;
        return $wpdb->get_results("
            SELECT post.ID, meta.meta_value FROM {$wpdb->prefix}posts as post
            LEFT JOIN {$wpdb->prefix}postmeta as meta ON post.ID = meta.post_id
            WHERE meta.meta_key = '1c_id'
        ");
    }

    public function getImportProductsData(): array
    {
        $xml_path = IMPORTER_PLUGIN_PATH . 'upload/xmls/import0_1.xml';
        $xml_data = simplexml_load_file($xml_path);

        $data = [];

        foreach ($xml_data->Каталог->Товары->Товар as $item) {
            $data[] = (string)$item->Ид;
        }

        return $data;
    }

    public function removeProduct($product_id) {
        $product = wc_get_product($product_id);
        $product->delete(true);
        return $product;
    }
}
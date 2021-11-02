<?php


class IM_Sku
{
    public static function getProductNotSku()
    {
        $products = wc_get_products(array(
            'limit'  => -1,
            'meta_key' => '_sku',
            'meta_value' => 'undefined'
        ));

        return count($products);
    }

    private $start_sku;

    public function __construct()
    {
        $config_path = IMPORTER_PLUGIN_PATH."upload/config/config.xml";
        $config = simplexml_load_file($config_path);

        $this->start_sku = (integer) $config->startSku;
    }

    public function getGeneratedSku()
    {
        $sku = str_pad($this->start_sku, 7, "0", STR_PAD_LEFT);
        $this->start_sku++;
        return $sku;
    }

    public function setSkuConfig()
    {
        $config_path = IMPORTER_PLUGIN_PATH."upload/config/config.xml";
        $this->config = simplexml_load_file($config_path);

        $this->config->startSku = $this->start_sku;
        $this->config->saveXML($config_path);
    }

    public static function getGeneratedItemSku()
    {
        $config_path = IMPORTER_PLUGIN_PATH."upload/config/config.xml";
        $config = simplexml_load_file($config_path);

        $current_sku = (integer) $config->startSku;
        $generated_sku = str_pad($current_sku, 7, "0", STR_PAD_LEFT);

        $current_sku++;
        $config->startSku = $current_sku;
        $config->saveXML($config_path);

        return $generated_sku;
    }
}
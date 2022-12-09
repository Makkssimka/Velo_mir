<?php


class IM_FilesImport
{
    private $archives_path,
            $images_path,
            $xmls_path,
            $all_product = 0,
            $new_product = 0,
            $update_product = 0;

    public function __construct()
    {
        $upload_path = IMPORTER_PLUGIN_PATH . 'upload/';
        $this->archives_path = $upload_path . 'archives/';
        $this->images_path = $upload_path . 'images/';
        $this->xmls_path = $upload_path . 'xmls/';
    }


    // Для ajax обновления продуктов

    public function unzip()
    {
        $this->cleanDataFolders();

        $archives_list = IM_FilesManager::getFilesToFolder($this->archives_path);

        if (count($archives_list)) {
            foreach ($archives_list as $archive) {
                $archive_path = $this->archives_path . $archive;
                IM_FilesManager::unzip($archive_path, $this->images_path, $this->xmls_path);
            }
        }
    }

    public function getData($global_step, $global_step_counter)
    {
        $log = new LogImporter();

        $xml_offers_path = $this->xmls_path . '/offers0_1.xml';
        $xml_offers_data = simplexml_load_file($xml_offers_path);

        // Создаем массив с ид товара в ключе и ценой и количеством в значении
        $price_quantity_array = array();
        foreach ($xml_offers_data->ПакетПредложений->Предложения->Предложение as $item) {
            $id = (string) $item->Ид;
            $price = (integer) $item->Цены->Цена->ЦенаЗаЕдиницу;
            $quantity = (integer) $item->Количество;
            $price_quantity_array[$id] = [
                'price' => $price,
                'quantity' => $quantity
            ];
        }

        unset($xml_offers_data);

        $xml_import_path = $this->xmls_path . '/import0_1.xml';
        $xml_import_data = simplexml_load_file($xml_import_path);

        // Создаем массив по аналогии для категорий
        $category_array = array();
        $this->getCategoryXml($xml_import_data->Классификатор->Группы, $category_array);

        // Создаем массив по аналогии для свойств и их значений
        $prop_array = array();
        $prop_value_array = array();
        foreach ($xml_import_data->Классификатор->Свойства->Свойство as $prop_parent) {
            $id = (string) $prop_parent->Ид;
            $attr = (string) $prop_parent->Наименование;
            $prop_array[$id] = $attr;


            if (!isset($prop_parent->ВариантыЗначений)) continue;

            foreach ($prop_parent->ВариантыЗначений->Справочник as $item) {
                $id = (string) $item->ИдЗначения;
                $value = (string) $item->Значение;
                $prop_value_array[$id] = $value;
            }
        }

        // Перебираем товары и содаем продукты со свойствами
        $products_array = [];
        $counter = 0;


        foreach ($xml_import_data->Каталог->Товары->Товар as $item) {
            $counter = $counter + 1;
            if ($counter < $global_step * $global_step_counter) continue;
            if ($counter > ($global_step * $global_step_counter + $global_step_counter)) break;

            $log->write($counter);

            $id = (string)$item->Ид;

            $name = (string)$item->Наименование;
            $sku = (string)$item->Артикул;
            $brand = (string)$item->Изготовитель->Наименование;
            $tags = [];

            $price = $price_quantity_array[$id]['price'];
            $quantity = $price_quantity_array[$id]['quantity'];

            $category_id = (string)$item->Группы->Ид;

            $description = $item->Описание ? (string)$item->Описание : '';
            $images = (array)$item->Картинка;

            $properties_product = null;
            $properties = $item->ЗначенияСвойств->ЗначенияСвойства;

            if ($properties) {
                foreach ($item->ЗначенияСвойств->ЗначенияСвойства as $property) {
                    $property_id = (string)$property->Ид;
                    $property_value_id = (string)$property->Значение;
                    $property_name = $prop_array[$property_id];
                    $property_value = $prop_value_array[$property_value_id];

                    if ($property_name === "Модель") {
                        $tags[] = $property_value;
                        continue;
                    };

                    $properties_product[] = array(
                        'name' => $property_name,
                        'slug' => IM_Helper::translit($property_name),
                        'value' => $property_value
                    );
                }
            }

            if ($brand) {
                $properties_product[] = array(
                    'name' => "Производитель",
                    'slug' => IM_Helper::translit("Производитель"),
                    'value' => $brand
                );
            }

            $products_array[] = array(
                'id' => $id,
                'name' => $name,
                'sku' => $sku,
                'price' => $price,
                'quantity' => $quantity,
                'category' => $category_id,
                'description' => $description,
                'images' => $images,
                'brand' => $brand,
                'properties' => $properties_product,
                'tags' => $tags,
            );
        }

        unset($xml_import_data);

        $log->write('import ' . count($products_array));

        return $products_array;
    }

    public function cleanDataFolders()
    {
        // Очищаем все папки
        self::cleanDir($this->images_path);
        self::cleanDir($this->xmls_path);
    }


    // Не ajax запросы

    public function run()
    {
        $archives_list = IM_FilesManager::getFilesToFolder($this->archives_path);

        if (count($archives_list)) {
            foreach ($archives_list as $archive) {
                $archive_path = $this->archives_path . $archive;
                IM_FilesManager::unzip($archive_path, $this->images_path, $this->xmls_path);
            }
        }

        $this->createProduct();
    }

    private function createProduct()
    {
        $xml_import_path = $this->xmls_path . '/import0_1.xml';
        $xml_import_data = simplexml_load_file($xml_import_path);

        $xml_offers_path = $this->xmls_path . '/offers0_1.xml';
        $xml_offers_data = simplexml_load_file($xml_offers_path);

        // Создаем массив с ид товара в ключе и ценой и количеством в значении
        $price_quantity_array = array();
        foreach ($xml_offers_data->ПакетПредложений->Предложения->Предложение as $item) {
            $id = (string) $item->Ид;
            $price = (integer) $item->Цены->Цена->ЦенаЗаЕдиницу;
            $quantity = (integer) $item->Количество;
            $price_quantity_array[$id] = [
                'price' => $price,
                'quantity' => $quantity
            ];
        }

        // Создаем массив категорий с сайта name => id
        $category_site_array = $this->getCategorySite();

        // Создаем массив по аналогии для категорий
        $category_array = array();
        $this->getCategoryXml($xml_import_data->Классификатор->Группы, $category_array);

        // Создаем массив продуктов с сайта id_1c => id
        $product_site_array = self::getProductSite();

        // Создаем массив по аналогии для свойств и их значений
        $prop_array = array();
        $prop_value_array = array();
        foreach ($xml_import_data->Классификатор->Свойства->Свойство as $prop_parent) {
            $id = (string) $prop_parent->Ид;
            $attr = (string) $prop_parent->Наименование;
            $prop_array[$id] = $attr;

            // Создаем свойство на сайте
            $this->createAttribute('Бренд');
            $this->createAttribute($attr);


            if (!isset($prop_parent->ВариантыЗначений)) continue;

            foreach ($prop_parent->ВариантыЗначений->Справочник as $item) {
                $id = (string) $item->ИдЗначения;
                $value = (string) $item->Значение;
                $prop_value_array[$id] = $value;
            }
        }

        // Перебираем товары и содаем продукты со свойствами
        foreach ($xml_import_data->Каталог->Товары->Товар as $item) {
            $id = (string) $item->Ид;

            $name_preg = '/(электросамокат|скейт-пениборд|скейтборд|скейт-лонгборд)/iu';
            $name = (string) $item->Наименование;
            $name = preg_replace($name_preg, '', $name);

            $brand = (string) $item->Изготовитель->Наименование;

            $price =  $price_quantity_array[$id]['price'];
            $quantity = $price_quantity_array[$id]['quantity'];

            $category_id = (string) $item->Группы->Ид;
            $category_name = mb_strtolower($category_array[$category_id]);
            $category_site_id = $category_site_array[$category_name];

            $description = $item->Описание ? (string) $item->Описание : '';
            $image = $item->Картинка ? (string) $item->Картинка : '';
            $sku = (string) $item->Штрихкод;

            $product = new IM_Product();
            $product->setId($id);
            $product->setName($name);
            $product->setPrice($price);
            $product->setQuantity($quantity);
            $product->setCategoryId($category_site_id);
            $product->setDescription($description);
            $product->setImagePath($image);
            $product->setSku($sku);
            $product->setBrand($brand);

            foreach ($item->ЗначенияСвойств->ЗначенияСвойства as $property) {
                $property_id = (string) $property->Ид;
                $property_value_id = (string) $property->Значение;
                $property_name = $prop_array[$property_id];
                $property_value = $prop_value_array[$property_value_id];

                $product->addProperties(array(
                    'name' => IM_Helper::translit($property_name),
                    'value' => $property_value
                ));
            }

            if (isset($product_site_array[$id])) {
                $product->save($product_site_array[$id]);
                $this->update_product++;
            } else {
                $product->save();
                $this->new_product++;
            }

            $this->all_product++;
        }

        // Очищаем все папки
        self::cleanDir($this->images_path);
        self::cleanDir($this->xmls_path);

    }

    public function getResultImport()
    {
        return array(
            'all' => $this->all_product,
            'new' => $this->new_product,
            'update' => $this->update_product
        );
    }

    private function getCategoryXml($groups, &$array)
    {
        foreach ($groups->Группа as $category) {
            $id = (string) $category->Ид;
            $name = (string) $category->Наименование;

            $array[$id] = $name;

            if ($category->Группы) $this->getCategoryXml($category->Группы, $array);
        }
    }

    private function getCategorySite()
    {
        $new_category_array = array();
        $category_site_array = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => false]);

        foreach ($category_site_array as $item) {
            $new_category_array[mb_strtolower($item->name)] = $item->term_id;
        }

        return $new_category_array;
    }

    private function createAttribute($attribute)
    {
        $attributes = array_values(wc_get_attribute_taxonomy_labels());

        if (!in_array($attribute, $attributes)) {
            wc_create_attribute([
                'name' => $attribute,
                'slug' => IM_Helper::translit($attribute)
            ]);
        }

        register_taxonomy('pa_'.IM_Helper::translit($attribute), 'product');
    }

    public static function cleanDir($dir)
    {
        $di = new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS);
        $ri = new RecursiveIteratorIterator($di, RecursiveIteratorIterator::CHILD_FIRST);
        foreach ( $ri as $file ) {
            $file->isDir() ?  rmdir($file) : unlink($file);
        }
        return true;
    }

    public static function countFileToDir($dir)
    {
        return count(glob($dir . "*.zip"));
    }

    public static function getProductSite()
    {
        $products_array = array();
        $products = wc_get_products(['limit' => -1]);

        foreach ($products as $product) {
            $products_array[$product->get_meta('1c_id', true)] = $product->get_id();
        }

        return $products_array;
    }
}

<?php


class IM_Product
{
    private $id,
            $name,
            $sku,
            $price,
            $quantity,
            $category_id,
            $description,
            $images,
            $tags,
            $properties = array(),
            $storages;

    /**
     * @param mixed $brand
     */
    public function setBrand($brand)
    {
        $property = array(
            'name' => IM_Helper::translit('Бренд'),
            'value' => $brand
        );

        array_push($this->properties, $property);
    }

    /**
     * @param mixed $properties
     */
    public function addProperties($properties)
    {
        array_push($this->properties, $properties);
    }

    /**
     * @param mixed $properties
     */
    public function createAndAddProperties($properties)
    {
        $attributes = array_values(wc_get_attribute_taxonomy_labels());

        foreach ($properties as $property) {

            if (!in_array($property['name'], $attributes)) {
                wc_create_attribute([
                    'name' => $property['name'],
                    'slug' => $property['slug']
                ]);
            }

            register_taxonomy('pa_'.$property['slug'], 'product');

            $this->addProperties(array(
                'name' => $property['slug'],
                'value' => $property['value']
            ));
        }
    }

    /**
     * @param mixed $image_path
     */
    public function setImages($images)
    {
        $this->images = $images;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param mixed $category_id
     */
    public function setCategoryId($category_id)
    {
        $this->category_id = $category_id;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param mixed $sku
     */
    public function setSku($sku)
    {
        $this->sku = $sku;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @param mixed $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * @param $tags
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
    }

    /**
     * @param $storages
     * @return void
     */
    public function setStorages($storages)
    {
        $this->storages = $storages;
    }

    /**
     * @throws WC_Data_Exception
     */
    public function save()
    {
        $product_query = new WP_Query([
            'post_type' => 'product',
            'post_status' => 'publish',
            'meta_query' => array (
                array(
                    'key' => '1c_id',
                    'value' => $this->id,
                    'compare' => '=',
                ),
            )
        ]);

        if (count($product_query->get_posts())) {
            $product = wc_get_product($product_query->get_posts()[0]->ID);

            if ($this->sku) {
                try {
                    $product->set_sku($this->sku);
                } catch (WC_Data_Exception $e) {
                    $product->set_sku($this->sku . '_' . $this->generateRandomString(5));
                }
            }
        } else {
            $product = new WC_Product();
            $product->update_meta_data('1c_id',$this->id);

            if ($this->sku) {
                try {
                    $product->set_sku($this->sku);
                } catch (WC_Data_Exception $e) {
                    $product->set_sku($this->sku . '_' . $this->generateRandomString(5));
                }
            } else {
                $product->set_sku(IM_Sku::getGeneratedItemSku());
            }

            $product->set_virtual(false);
            $product->set_manage_stock(true);
        }

        $product->set_name($this->name);

        $product->set_sale_price($this->price);
        $product->set_regular_price(round(($this->price*100/80)/10)*10);

        $product->set_stock_quantity($this->quantity);
        $product->set_category_ids([$this->category_id]);

        $description = explode('@', $this->description);
        $product->set_description($description[0] ?? '');
        $product->set_short_description(array_key_exists(1, $description) ? nl2br($description[1]) : '');

        $product->update_meta_data('storages',$this->storages);

        $attributes_array = array();
        foreach ($this->properties as $property) {
            $attribute = $this->createAttribute($property);
            $attributes_array[] = $attribute;
        }

        $product->set_attributes($attributes_array);

        // Перебираем картинки, первой делаем картинку обложкой, остальные в галлерею
        if ($this->images && count($this->images)) {
            $product_image_id = null;
            $product_gallery_ids = [];
            foreach ($this->images as $key => $image) {
                if ($key === 0) {
                    $product_image_id = $this->createImageProduct($image);
                } else {
                    $product_gallery_ids[] = $this->createImageProduct($image);
                }

            }

            $product->set_image_id($product_image_id);
            $product->set_gallery_image_ids($product_gallery_ids);
        }

        $product_id = $product->save();
        wp_set_object_terms($product_id, $this->tags, 'product_tag');
    }

    /**
     * Создаем значение аттрибута
     * @param $property
     * @return WC_Product_Attribute
     */

    private function createAttribute($property)
    {
        $attribute_id = wc_attribute_taxonomy_id_by_name($property['name']);
        $attribute = new WC_Product_Attribute();
        $attribute->set_id($attribute_id);
        $attribute->set_name( 'pa_'.$property['name'] );
        $attribute->set_visible( true );
        $attribute->set_variation( false );
        $attribute->set_options([$property['value']]);

        return $attribute;
    }

    private function createImageProduct($image)
    {
        $file = $this->moveImageProduct($image);
        $mime_file = mime_content_type($file);

        $image = get_page_by_title(basename($file), OBJECT, 'attachment');

        if ($image) {
            $image_id = $image->ID;
        } else {
            $args = array(
                'post_mime_type' => $mime_file,
                'post_title' => basename($file),
                'post_content' => '',
                'post_status' => 'inherit',
                'guid' => $file
            );
            $image_id = wp_insert_attachment($args, $file);
        }

        return $image_id;
    }

    private function moveImageProduct($image)
    {
        $file_name = basename($image);
        $start_path = IMPORTER_PLUGIN_PATH . 'upload/images/' . $image;
        $end_path = WP_CONTENT_DIR . '/uploads/images-product/' . $file_name;

        rename($start_path, $end_path);
        return $end_path;
    }

    private function generateRandomString($length = 10) {
        return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
    }

}
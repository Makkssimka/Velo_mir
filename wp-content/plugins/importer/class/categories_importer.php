<?php


class IM_CategoriesImport
{
    private $import_path,
            $categories = array(),
            $categoriesAjax = array();

    public function __construct()
    {
        $upload_path = IMPORTER_PLUGIN_PATH . 'upload/';
        $this->import_path = $upload_path . 'xmls/import0_1.xml';
    }

    public function run()
    {
        $import_data = simplexml_load_file($this->import_path);
        $this->recursiveCreate($import_data->Классификатор->Группы);
    }

    private function recursiveCreate($categories, $parent_id = null)
    {
        foreach ($categories->Группа as $category_1c) {
            $id = (string) $category_1c->Ид;
            $name = (string) $category_1c->Наименование;

            $category = new IM_Category();
            $category->setId($id);
            $category->setName($name);
            $category->setParent($parent_id);

            $this->add($category);

            if ($category_1c->Группы) {
                $this->recursiveCreate($category_1c->Группы, $id);
            }
        }
    }

    private function add($category)
    {
        $this->categories[$category->getId()] = $category;
    }

    public static function getSiteCategories()
    {
        $categoriesIdToName = array();
        $categories = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => false]);
        foreach ($categories as $category) {
            $desc_list = explode(', ',$category->description);
            foreach ($desc_list as $item) {
                $categoriesIdToName[$item] = [
                    'name' => $category->name,
                    'id' => $category->term_id
                ];
            }
        }

       return $categoriesIdToName;
    }

    /**
     * @return array
     */
    public function getCategories()
    {
        return $this->categories;
    }

    public function runAjax()
    {
        $import_data = simplexml_load_file($this->import_path);
        $this->recursiveCreateAjax($import_data->Классификатор->Группы);
    }

    private function recursiveCreateAjax($categories, $parent_id = null)
    {
        foreach ($categories->Группа as $category_1c) {
            $id = (string) $category_1c->Ид;
            $name = (string) $category_1c->Наименование;

            $category = [
                'id' => $id,
                'name' => $name,
                'parent' => $parent_id
            ];

            $this->addAjax($category);

            if ($category_1c->Группы) {
                $this->recursiveCreateAjax($category_1c->Группы, $id);
            }
        }
    }

    private function addAjax($category)
    {
        $this->categoriesAjax[] = $category;
    }

    public function getCategoriesAjax()
    {
        return $this->categoriesAjax;
    }
}
<?php


class IM_Category
{
    private $id,
            $name,
            $parent;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $name = str_replace('@', '', $name);
        $name = str_replace('_', ' ', $name);
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param mixed $parent
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    public function save()
    {
        $parents = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => false, 'description__like' => $this->getParent()]);
        $parent = array_shift($parents);

        $elements = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => false, 'description__like' => $this->getId()]);
        $element = array_shift($elements);

        if (!$element) {
            wp_insert_term(
                $this->getName(),
                'product_cat',
                array(
                    'description' => $this->getId(),
                    'slug' => IM_Helper::translit($this->getName()),
                    'parent' => $this->getParent() ? $parent->term_id: ''
                )
            );
        }
    }


}
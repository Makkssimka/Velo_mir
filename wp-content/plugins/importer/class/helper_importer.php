<?php


class IM_Helper
{
    public static function translit($value)
    {
        $converter = array(
            'а' => 'a',    'б' => 'b',    'в' => 'v',    'г' => 'g',    'д' => 'd',
            'е' => 'e',    'ё' => 'e',    'ж' => 'zh',   'з' => 'z',    'и' => 'i',
            'й' => 'y',    'к' => 'k',    'л' => 'l',    'м' => 'm',    'н' => 'n',
            'о' => 'o',    'п' => 'p',    'р' => 'r',    'с' => 's',    'т' => 't',
            'у' => 'u',    'ф' => 'f',    'х' => 'h',    'ц' => 'c',    'ч' => 'ch',
            'ш' => 'sh',   'щ' => 'sch',  'ь' => '',     'ы' => 'y',    'ъ' => '',
            'э' => 'e',    'ю' => 'yu',   'я' => 'ya',   ' ' => '-',    ',' => '',
            '(' => '', ')' => '', '/' => '', '.' => ''
        );

        $value = trim(mb_strtolower($value));
        $value = strtr($value, $converter);
        return $value;
    }

    public static function tabNameCategory($category, $categories)
    {
        $prefix = '';

        if ($category->getParent()) {
            $prefix = '— ';
            $parent = $categories[$category->getParent()];
            $prefix .= self::tabNameCategory($parent,$categories);
        }

        return $prefix;
    }

    public static function getSiteCategoryId($id)
    {
        $categories = get_terms(
            [
                'taxonomy' => 'product_cat',
                'hide_empty' => false,
                'description__like' => $id
            ]);

        $category = array_shift($categories);

        return $category->term_id;
    }
}
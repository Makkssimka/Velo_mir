<?php


class IM_FilesManager
{
    public static function getFilesToFolder($folder)
    {
        $result = array();

        $dir = scandir($folder);
        foreach ($dir as $key => $value)
        {
            if (!in_array($value,array(".","..",".DS_Store")))
            {
                if (is_dir($folder . DIRECTORY_SEPARATOR . $value))
                {
                    $result[$value] = self::getFilesToFolder($folder . DIRECTORY_SEPARATOR . $value);
                }
                else
                {
                    $result[] = $value;
                }
            }
        }

        return $result;
    }

    public static function getFileExt($file)
    {
        return pathinfo($file, PATHINFO_EXTENSION);
    }

    public static function getFileName($file)
    {
        return pathinfo($file, PATHINFO_BASENAME);
    }

    public static function unzip($file, $image_path, $xml_path)
    {
        $zip = new ZipArchive();
        $zip->open($file);

        $i = 0;
        while($name = $zip->getNameIndex($i)) {
            $file_ext = self::getFileExt($name);

            switch ($file_ext) {
                case 'png':
                case 'jpeg':
                case 'jpg':
                    $zip->extractTo($image_path, $name);
                    break;
                default:
                    $zip->extractTo($xml_path, $name);
                    break;
            }
            $i++;
        }

        $zip->close();
    }
}
<?php

namespace App\Helpers;


class FileHelper
{
    /**
     * @param array $type
     * @return array|false
     */
    public static function getIconOfAdmin($types = [])
    {
        $allFiles = array_diff(scandir(public_path('admin/dist/icons')), array('.', '..'));
        if (count($types) == 0) {
            return $allFiles;
        }else{
            $newAllFiles = [];
            foreach ($allFiles as $file) {
                if (in_array(pathinfo($file)['extension'], $types)) {
                    $newAllFiles[] = $file;
                }
            }
            return $newAllFiles;
        }
    }
}

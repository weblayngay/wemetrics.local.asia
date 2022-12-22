<?php
namespace App\Helpers;
use App\Models\Image;

class ImageHelper
{
    /**
     * @param $file
     * @param $model
     * @param int $id
     * @param $folder
     */
    static function uploadImage($file, $type, $id = 0, $value = '', $pathSave = '', $colorId = 0)
    {
        list($width, $height) = getimagesize($file->getRealPath());
        /**upload image*/
        $originalName = $file->getClientOriginalName();
        $filename = pathinfo($originalName, PATHINFO_FILENAME);
        $extension = pathinfo($originalName, PATHINFO_EXTENSION);
        $name = $filename .'-'. time() . "." . $extension;
        $file->storeAs($pathSave, $name, 'image');

        $data = [
            'image_value'       => $value,
            '3rd_key'           => $id,
            '3rd_type'          => $type,
            'rd_type_2'         => $colorId,
            'image_height'      => $height,
            'image_width'       => $width,
            'image_name'        => $name,
            'image_type'        => strtolower($extension),
            'image_status'      => 'activated'
        ];
        Image::query()->create($data);
    }

    /**
     * @param $file
     * @param $folder
     * @param $imageId
     */
    static function uploadUpdateImage($file, $folder, $imageId, $pathSave, $colorId = 0)
    {
        list($width, $height) = getimagesize($file->getRealPath());
        /**upload image*/
        $originalName = $file->getClientOriginalName();
        $filename = pathinfo($originalName, PATHINFO_FILENAME);
        $extension = pathinfo($originalName, PATHINFO_EXTENSION);
        $name = $filename .'-'. time() . "." . $extension;
        $file->storeAs($pathSave, $name, 'image');

        $data = [
            'rd_type_2'         => $colorId,
            'image_height'      => $height,
            'image_width'       => $width,
            'image_name'        => $name,
            'image_type'        => strtolower($extension),
            'image_status'      => 'activated'
        ];

        Image::query()->where('image_id', $imageId)->update($data);
    }


    /**
     * @param $files
     * @param $model
     * @param int $id
     * @param $folder
     */
    static function uploadMultipleImage($files, $type, $id = 0, $value = '', $pathSave = '', $imagecolor = [])
    {
        foreach ($files as $key => $file){
            self::uploadImage($file, $type, $id, $value, $pathSave, (int)$imagecolor[$key]);
        }
    }
}

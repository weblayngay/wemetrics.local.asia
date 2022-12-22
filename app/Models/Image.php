<?php

namespace App\Models;

use App\Helpers\ArrayHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Image extends BaseModel
{
    use HasFactory;
    protected $table = IMAGE_TBL;
    protected $primaryKey = 'image_id';
    const CREATED_AT = 'image_created_at';
    const UPDATED_AT = 'image_update_at';

    protected $fillable = [
        'image_id',
        'image_value',
        '3rd_key',
        '3rd_type',
        'rd_type_2',
        'image_height',
        'image_width',
        'image_name',
        'image_type',
        'image_is_deleted',
        'image_status',
        'image_created_at',
        'image_update_at',
    ];

    const ALIAS = [
        'image_id'          => 'id',
        'image_value'       => 'value',
        '3rd_key'           => '3rdKey',
        '3rd_type'          => '3rdType',
        'rd_type_2'         => 'rdType2',
        'image_height'      => 'height',
        'image_width'       => 'width',
        'image_name'        => 'name',
        'image_type'        => 'type',
        'image_is_deleted'  => 'isDeleted',
        'image_status'      => 'status',
        'image_created_at'  => 'createdAt',
        'image_updated_at'  => 'updatedAt'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    static function parentQuery(){
        return parent::query();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    static function query()
    {
        return parent::query()->notDeleted();
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeNotDeleted($query)
    {
        return $query->where('image_is_deleted', 'no');
    }

    /**
     * @param $id
     * @return array
     */
    public function getDataDuplicate($id)
    {
        $item = $this->query()->where('image_id', $id)
            ->select('image_value', '3rd_key', '3rd_type', 'rd_type_2', 'image_height', 'image_width', 'image_name', 'image_type', 'image_is_deleted', 'image_status')
            ->first();
        return $item;
    }

    /**
     * @param $array
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getArrayDataDuplicate($array)
    {
        $data = $this->query()->whereIn('image_id', $array)
            ->select('image_value', '3rd_key', '3rd_type', 'rd_type_2', 'image_height', 'image_width', 'image_name', 'image_type', 'image_is_deleted', 'image_status')
            ->get();
        return $data;
    }

    /**
     * @param $array
     * @param $model
     * @param $id
     */
    public function updateColor($array, $model, $id)
    {
        $valueThumbnail = config('my.image.value.product.thumbnail');
        $valueBanner = config('my.image.value.product.banner');

        $imageThumbnail = $this->query()->where(['3rd_key' => $id, '3rd_type' => $model, 'image_value' => $valueThumbnail])->orderBy('image_id', 'ASC')->get();
        $imageBanner = $this->query()->where(['3rd_key' => $id, '3rd_type' => $model, 'image_value' => $valueBanner])->orderBy('image_id', 'ASC')->get();

        $thumbnailIds = [];
        if($imageThumbnail->count() > 0){
            $thumbnailIds = array_column($imageThumbnail->toArray(), 'image_id');
        }
        $bannerIds = [];
        if($imageBanner->count() > 0){
            $bannerIds = array_column($imageBanner->toArray(), 'image_id');
        }

        $combineThumbnail = ArrayHelper::arrayCombine($array,$thumbnailIds);
        $combineBanner = ArrayHelper::arrayCombine($array,$bannerIds);


        if(count($thumbnailIds) > 0){
            foreach ($thumbnailIds as $key => $iT){
                $thumbnail = $this->query()->where('image_id', $iT)->first();
                if($thumbnail){
                    $thumbnail->update(['rd_type_2' => $combineThumbnail[$iT]]);
                }
            }
        }

        if(count($bannerIds) > 0){
            foreach ($bannerIds as $key => $iB){
                $banner = $this->query()->where('image_id', $iB)->first();
                if($banner){
                    $banner->update(['rd_type_2' => $combineBanner[$iB]]);
                }
            }
        }

    }
}

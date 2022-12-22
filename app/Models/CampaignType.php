<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use DB;

class CampaignType extends BaseModel
{
    use HasFactory;
    protected $table    = CAMPAIGN_TYPE_TBL;
    protected $primaryKey = 'campaigntype_id';
    const CREATED_AT = 'campaigntype_created_at';
    const UPDATED_AT = 'campaigntype_updated_at';

    protected $fillable = [
        'campaigntype_id',
        'campaigntype_created_at',
        'campaigntype_update_at',
        'campaigntype_created_by',
        'campaigntype_updated_by',
        'campaigntype_deleted_by',
        
        //vi
        'campaigntype_name',
        'campaigntype_status',
        'campaigntype_description',
        'campaigntype_is_delete',

    ];

    const ALIAS = [
        'campaigntype_id'               => 'id',
        'campaigntype_created_at'       => 'createdAt',
        'campaigntype_update_at'        => 'updatedAt',
        'campaigntype_created_by'       => 'createdBy',
        'campaigntype_updated_by'       => 'updatedBy',
        'campaigntype_deleted_by'       => 'deletedBy',
        //vi
        'campaigntype_name'             => 'name',
        'campaigntype_status'           => 'status',
        'campaigntype_description'      => 'description',
        'campaigntype_is_delete'        => 'isDelete',
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
    static function query($isDeleted = true)
    {
        if($isDeleted == true)
        {
            return parent::query()->notDeleted()->OrderByDesc();
        } else {
            return parent::query()->OrderByDesc();
        }
        
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeOrderByDesc($query)
    {
        return $query->orderby('campaigntype_id', 'desc');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeNotDeleted($query)
    {
        return $query->where('campaigntype_is_delete', 'no');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeIsActivated($query)
    {
        return $query->where('campaigntype_status', 'activated');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    static function search($column, $searchStr, $status, $isUsed, $paginateNum)
    {
        $result = DB::table(CAMPAIGN_TYPE_TBL. ' as t1')
                ->leftjoin(CAMPAIGN_TBL.' as t2', 't1.campaigntype_id', '=', 't2.campaign_type')
                ->select('t1.*', DB::raw('CASE WHEN t2.campaign_id != "" THEN "yes" ELSE "no" END AS campaigntype_used'))
                ->where($column, 'LIKE', '%'.$searchStr.'%')
                ->where(DB::raw('CASE WHEN t2.campaign_id != "" THEN "yes" ELSE "no" END'), 'LIKE', '%'.$isUsed.'%')
                ->where('t1.campaigntype_status', 'LIKE', '%'.$status.'%')
                ->orderby('t1.campaigntype_id', 'desc')
                ->get();

        return $result;
    }

    /**
     * @return HasMany
     */
    public function campaigns(): HasMany
    {
        return parent::HasMany('App\Models\Campaign', 'campaign_type', 'campaigntype_id');
    }

    /**
     * @return HasOne
     */
    public function avatar(): HasOne
    {
        return parent::hasOne('App\Models\Image', '3rd_key', 'campaigntype_id')
            ->where(['3rd_type' => 'campaigntype', 'image_value' => config('my.image.value.campaigntype.avatar'), 'image_status' => 'activated']);
    }
}

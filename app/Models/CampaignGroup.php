<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use DB;

class CampaignGroup extends BaseModel
{
    use HasFactory;
    protected $table    = CAMPAIGN_GROUP_TBL;
    protected $primaryKey = 'campaigngroup_id';
    const CREATED_AT = 'campaigngroup_created_at';
    const UPDATED_AT = 'campaigngroup_updated_at';

    protected $fillable = [
        'campaigngroup_id',
        'campaigngroup_created_at',
        'campaigngroup_update_at',
        'campaigngroup_created_by',
        'campaigngroup_updated_by',
        'campaigngroup_deleted_by',
        
        //vi
        'campaigngroup_name',
        'campaigngroup_status',
        'campaigngroup_description',
        'campaigngroup_is_delete',
        'campaigngroup_parent',

    ];

    const ALIAS = [
        'campaigngroup_id'               => 'id',
        'campaigngroup_created_at'       => 'createdAt',
        'campaigngroup_update_at'        => 'updatedAt',
        'campaigngroup_created_by'       => 'createdBy',
        'campaigngroup_updated_by'       => 'updatedBy',
        'campaigngroup_deleted_by'       => 'deletedBy',
        //vi
        'campaigngroup_name'             => 'name',
        'campaigngroup_status'           => 'status',
        'campaigngroup_description'      => 'description',
        'campaigngroup_is_delete'        => 'isDelete',
        'campaigngroup_parent'           => 'parent',
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
        return $query->orderby('campaigngroup_id', 'desc');
    }

     /**
     * @return hasMany
     */
     public function items()
     {
        return $this->hasMany(self::class, 'campaigngroup_parent');
     }

     /**
     * @return hasMany
     */
     public function childItems()
     {
        return $this->hasMany(self::class, 'campaigngroup_parent')->with('items');
     }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeNotDeleted($query)
    {
        return $query->where('campaigngroup_is_delete', 'no');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeIsActivated($query)
    {
        return $query->where('campaigngroup_status', 'activated');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeIsParent($query)
    {
        return $query->where('campaigngroup_parent', 0);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeNotParent($query)
    {
        return $query->where('campaigngroup_parent', '<>', 0);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    static function search($column, $searchStr, $status, $isUsed, $paginateNum)
    {
        $result = DB::table(CAMPAIGN_GROUP_TBL. ' as t1')
                ->leftjoin(CAMPAIGN_TBL.' as t2', 't1.campaigngroup_id', '=', 't2.campaign_group')
                ->select('t1.*', DB::raw('CASE WHEN t2.campaign_id != "" THEN "yes" ELSE "no" END AS campaigngroup_used'))
                ->where($column, 'LIKE', '%'.$searchStr.'%')
                ->where(DB::raw('CASE WHEN t2.campaign_id != "" THEN "yes" ELSE "no" END'), 'LIKE', '%'.$isUsed.'%')
                ->where('t1.campaigngroup_status', 'LIKE', '%'.$status.'%')
                ->orderby('t1.campaigngroup_id', 'desc')
                ->get();

        return $result;
    }

    /**
     * @return HasMany
     */
    public function campaigns(): HasMany
    {
        return parent::HasMany('App\Models\Campaign', 'campaign_group', 'campaigngroup_id');
    }

    /**
     * @return HasOne
     */
    public function avatar(): HasOne
    {
        return parent::hasOne('App\Models\Image', '3rd_key', 'campaigngroup_id')
            ->where(['3rd_type' => 'campaigngroup', 'image_value' => config('my.image.value.campaigngroup.avatar'), 'image_status' => 'activated']);
    }
}

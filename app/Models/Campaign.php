<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Campaign extends BaseModel
{
    use HasFactory;
    protected $table    = CAMPAIGN_TBL;
    protected $primaryKey = 'campaign_id';
    const CREATED_AT = 'campaign_created_at';
    const UPDATED_AT = 'campaign_updated_at';
    const EXPIRED_AT = 'campaign_expired_at';

    protected $fillable = [
        'campaign_id',
        'campaign_group',
        'campaign_type',
        'campaign_slug',
        'campaign_url',
        'campaign_group',
        'campaign_created_at',
        'campaign_updated_at',
        'campaign_began_at',
        'campaign_expired_at',
        'campaign_created_by',
        'campaign_updated_by',
        'campaign_deleted_by',

        //vi
        'campaign_name',
        'campaign_description',
        'campaign_status',
        'campaign_is_delete',
        'campaign_is_used',
    ];

    const ALIAS = [
        'campaign_id'               => 'id',
        'campaign_group'            => 'group',
        'campaign_type'             => 'type',
        'campaign_slug'             => 'slug',
        'campaign_url'              => 'url',
        'campaign_group'            => 'group',
        'campaign_created_at'       => 'createdAt',
        'campaign_updated_at'       => 'updateAt',
        'campaign_began_at'         => 'beganAt',
        'campaign_expired_at'       => 'expiredAt',
        'campaign_created_by'       => 'createdBy',
        'campaign_updated_by'       => 'updatedBy',
        'campaign_deleted_by'       => 'deletedBy',
        'campaign_name'             => 'name',
        'campaign_description'      => 'description',
        'campaign_status'           => 'status',
        'campaign_is_delete'        => 'isDelete',
        'campaign_is_used'          => 'isUsed',
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
        return $query->orderby('campaign_id', 'desc');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeNotDeleted($query)
    {
        return $query->where('campaign_is_delete', 'no');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeIsActivated($query)
    {
        return $query->where('campaign_status', 'activated');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    static function search($column, $searchStr, $group, $type, $isUsed, $status, $paginateNum)
    {
        return parent::query()->where($column, 'LIKE', '%'.$searchStr.'%')
                                ->where('campaign_group', 'LIKE', '%'.$group.'%')
                                ->where('campaign_type', 'LIKE', '%'.$type.'%')
                                ->where('campaign_is_used', 'LIKE', '%'.$isUsed.'%')
                                ->where('campaign_status', 'LIKE', '%'.$status.'%')
                                ->OrderByDesc()
                                ->paginate($paginateNum);
    }

    /**
     * @return BelongsTo
     */
    public function groups(): BelongsTo
    {
        return $this->belongsTo('App\Models\CampaignGroup', 'campaigngroup_id', 'campaign_group');
    }

    /**
     * @return HasOne
     */
    public function group(): HasOne
    {
        return $this->HasOne('App\Models\CampaignGroup', 'campaigngroup_id', 'campaign_group');
    }

    /**
     * @return BelongsTo
     */
    public function types(): BelongsTo
    {
        return $this->belongsTo('App\Models\CampaignType', 'campaigntype_id', 'campaign_type');
    }

    /**
     * @return HasOne
     */
    public function type(): HasOne
    {
        return $this->HasOne('App\Models\CampaignType', 'campaigntype_id', 'campaign_type');
    }

    /**
     * @return BelongsTo
     */
    public function campaignGroups(): BelongsTo
    {
        return $this->belongsTo('App\Models\VoucherGroup', 'campaigngroup_id', 'campaign_group');
    }

    /**
     * @return HasOne
     */
    public function campaignGroup(): HasOne
    {
        return $this->HasOne('App\Models\VoucherGroup', 'campaigngroup_id', 'campaign_group');
    }

    /**
     * @return HasMany
     */
    public function blocks(): HasMany
    {
        return parent::HasMany('App\Models\Block', 'block_campaign', 'campaign_slug');
    }

    /**
     * @return HasMany
     */
    public function campaignResults(): HasMany
    {
        return $this->HasMany('App\Models\CampaignResult', 'campaign_id', 'campaign_id');
    }

    /**
     * @return HasOne
     */
    public function avatar(): HasOne
    {
        return parent::hasOne('App\Models\Image', '3rd_key', 'campaign_id')
            ->where(['3rd_type' => 'campaign', 'image_value' => config('my.image.value.campaign.avatar'), 'image_status' => 'activated']);
    }
}

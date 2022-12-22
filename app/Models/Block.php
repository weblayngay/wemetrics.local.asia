<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Block extends BaseModel
{
    use HasFactory;

    protected $table = BLOCK_TBL;
    protected $primaryKey = 'block_id';
    const CREATED_AT = 'block_created_at';
    const UPDATED_AT = 'block_updated_at';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'block_id',
        'block_created_at',
        'block_updated_at',
        'block_created_by',
        'block_updated_by',
        'block_deleted_by',

        'block_name',
        'block_code',
        'block_sorted',
        'block_status',
        'block_campaign',
        'block_page',
        'block_banner_group',
        'block_is_delete',
    ];

    const ALIAS = [
        'block_id'               => 'id',
        'block_created_at'       => 'createdAt',
        'block_updated_at'       => 'updatedAt',
        'block_created_by'       => 'createdBy',
        'block_updated_by'       => 'updatedBy',
        'block_deleted_by'       => 'deletedBy',

        //vi
        'block_name'             => 'name',
        'block_code'             => 'code',
        'block_sorted'           => 'sorted',
        'block_status'           => 'status',
        'block_campaign'         => 'campaign',
        'block_page'             => 'page',
        'block_banner_group'     => 'bannerGroup',
        'block_is_delete'        => 'isDelete',
    ];


    /**
     * @return Builder
     */
    static function parentQuery(): Builder
    {
        return parent::query();
    }

    /**
     * @return Builder
     */
    static function query(): Builder
    {
        return parent::query();
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeIsActivated($query)
    {
        return $query->where('block_status', 'activated');
    }

    /**
     * @param string $status
     * @return Builder[]|Collection
     */
    public function findByStatus($status = 'activated')
    {
        return self::parentQuery()->where('block_status', $status)->orderBy('block_sorted', 'asc')->get();
    }

    /**
     * @return BelongsTo
     */
    public function campaigns(): BelongsTo
    {
        return $this->belongsTo('App\Models\Campaign', 'campaign_slug', 'block_campaign');
    }

    /**
     * @return BelongsTo
     */
    public function campaign(): HasOne
    {
        return $this->HasOne('App\Models\Campaign', 'campaign_slug', 'block_campaign');
    }
}

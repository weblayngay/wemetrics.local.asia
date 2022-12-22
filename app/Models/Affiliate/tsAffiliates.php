<?php

namespace App\Models\Affiliate;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;
use App\Models\BaseModel;

class tsAffiliates extends BaseModel
{
    use HasFactory;

    protected $table = TS_AFFILIATES;
    protected $primaryKey = 'id';
    const CREATED_AT = '';
    const UPDATED_AT = '';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'gid',
        'name',
        'username',
        'email',
        'password',
        'address',
        'phone',
        'hits',
        'adid',
        'gender',
        'idnum',
        'iddate',
        'idplace',
        'birth',
        'birthplace',
        'bk_name',
        'bk_pgd',
        'bk_province',
        'bk_acnum',
        'bk_acname',
        'registerdate',
        'lastvisitdate',
        'ip',
        'activation',
        'enable',
    ];

    const ALIAS = [
        'gid'           => 'gid',
        'name'          => 'name',
        'username'      => 'username',
        'email'         => 'email',
        'password'      => 'password',
        'address'       => 'address',
        'phone'         => 'phone',
        'hits'          => 'hits',
        'adid'          => 'adid',
        'gender'        => 'gender',
        'idnum'         => 'idnum',
        'iddate'        => 'iddate',
        'idplace'       => 'idplace',
        'birth'         => 'birth',
        'birthplace'    => 'birthplace',
        'bk_name'       => 'bk_name',
        'bk_pgd'        => 'bk_pgd',
        'bk_province'   => 'bk_province',
        'bk_acnum'      => 'bk_acnum',
        'bk_acname'     => 'bk_acname',
        'registerdate'  => 'registerdate',
        'lastvisitdate' => 'lastvisitdate',
        'ip'            => 'ip',
        'activation'    => 'activation',
        'enable'        => 'enable',
    ];

    /**
     * @return Builder
     */
    static function parentQuery(){
        return parent::query();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    static function query()
    {
        return parent::query();
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeIsEnabled($query)
    {
        return $query
        ->where('enable', '1');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeIsNotEnabled($query)
    {
        return $query
        ->where('enable', '0');
    }
}

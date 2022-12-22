<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * Class AdminMenu
 * @property int admenu_id
 * @property string name
 * @property string controller
 * @property string action
 * @property int parent
 * @property string status
 * @property string icon
 * @method isActivated
 * @method isParent
 * @method notParent
 * @package App\Models
 */
class AdminMenu extends Model
{
    use HasFactory;

    protected $table = ADMIN_MENU_TBL;

    protected $primaryKey = 'admenu_id';

    const CREATED_AT = null;

    const UPDATED_AT = null;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'controller',
        'action',
        'name',
        'parent',
        'status',
        'icon',
    ];

    /**
     * @param string $menuType
     * @return Builder[]|Collection
     */
    public function getMenuByUser($menuType = 'parent')
    {
        $conditionParent = ($menuType == 'parent') ? '=' : '>';
        /**
         * @var AdminUser $adminUser
         */
        if ($adminUser = Auth::guard('admin')->user()) {
            if (in_array($adminUser->aduser_id, ROOT_USER_IDS) && in_array($adminUser->adgroup_id, ROOT_GROUP_IDS)){
                return static::query()->where('parent', $conditionParent,0)->orderBy('name')->get();
            }else{
                $adminMenuArr = [0];
                if ($adminUser->admingroup instanceof AdminGroup) {
                    if ($adminMenuIds = $adminUser->admingroup->admenu_ids) {
                        $adminMenuArr = explode(',', $adminMenuIds);
                        $adminMenuArr = array_filter($adminMenuArr);
                    }
                }
                return static::query()->where('parent', $conditionParent,0)->whereIn('admenu_id', $adminMenuArr)->orderBy('name')->get();
            }
        }else{
            return static::query()->where('parent', 0)->where('admenu_id', 0)->orderBy('name')->get();
        }
    }

    /**
     * @return Builder
     */
    public static function parentQuery(): Builder
    {
        return parent::query();
    }

    /**
     * @return Builder
     */
    public static function query(): Builder
    {
        return parent::query()->isActivated();
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeIsActivated($query)
    {
        return $query->where('status', 'activated');
    }


    /**
     * @param $query
     * @return mixed
     */
    public function scopeIsParent($query)
    {
        return $query->where('parent', 0);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeNotParent($query)
    {
        return $query->where('parent', '<>', 0);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeIsGroup($query, $group)
    {
        return $query->where('group', $group);
    }

    /**
     * @param string $type
     * @return mixed
     */
    public function getMenusByType(string $type = 'all')
    {
        if ($type == 'parent') {
            return $this::parentQuery()->isParent()->get();
        } elseif ($type == 'children') {
            return $this::parentQuery()->notParent()->get();
        } else {
            return $this::parentQuery()->get();
        }
    }

    /**
     * @param string $type
     * @return mixed
     */
    public function getMenuItems(string $group = '')
    {
        return $this::parentQuery()->notParent()->IsActivated()->IsGroup($group)->get();
    }

}

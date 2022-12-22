<?php

namespace App\Models;

use App\Notifications\ResetPassword;
use App\Notifications\VerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property string email
 * Class User
 * @package App\Models
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $table = USER_TBL;
    protected $primaryKey = 'id';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'gender',
        'code',
        'phone',
        'email',
        'password',
        'oauth_id',
        'type',
        'status',
        'birthday',
        'facebook_id',
        'gmail',
        'zalo_id',
        'product_wishlists',
        'address',
        'ward_id',
        'province_id',
        'district_id',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
        'deleted_by',
        'is_delete',
        'token_reset_password',
        'time_reset_password',

        //delivery
        'delivery_name',
        'delivery_email',
        'delivery_phone',
        'delivery_address',
        'delivery_ward_id',
        'delivery_province_id',
        'delivery_district_id',
    ];

    const ALIAS = [
        'name'               => 'name',
        'code'               => 'code',
        'phone'              => 'phone',
        'email'              => 'email',
        'password'           => 'password',
        'oauth_id'           => 'oauth_id',
        'type'               => 'type',
        'status'             => 'status',
        'birthday'           => 'userBirthday',
        'gender'             => 'gender',
        'facebook_id'        => 'facebookId',
        'gmail'              => 'gmail',
        'zalo_id'            => 'zaloId',
        'product_wishlists'  => 'product_wishlists',
        'address'            => 'address',
        'ward_id'            => 'wardId',
        'province_id'        => 'provinceId',
        'district_id'        => 'districtId',
        'created_at'         => 'created_at',
        'updated_at'         => 'updated_at',
        'created_by'         => 'createdBy',
        'updated_by'         => 'updatedBy',
        'deleted_by'         => 'deletedBy',
        'is_delete'          => 'delete',
        'token_reset_password' => 'token_reset_password',
        'time_reset_password'  => 'time_reset_password',

        //delivery
        'delivery_name'         => 'deliveryName',
        'delivery_email'        => 'deliveryEmail',
        'delivery_phone'        => 'deliveryPhone',
        'delivery_address'      => 'deliveryAddress',
        'delivery_ward_id'      => 'deliveryWardId',
        'delivery_province_id'  => 'deliveryProvinceId',
        'delivery_district_id'  => 'deliveryDistrictId',

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /**
     * @return Builder
     */
    public static function parentQuery(): Builder
    {
        return parent::query();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    static function query($isDeleted = true)
    {
        if($isDeleted == true)
        {
            return parent::query()->notDeleted();
        } else {
            return parent::query();
        }
        
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeNotDeleted($query)
    {
        return $query->where('is_delete', 'no');
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail());
    }

    /**
     * Mark the given user's email as verified.
     *
     * @return bool
     */
    public function markEmailAsVerified()
    {
        $this->forceFill([
            'email_verified_at' => $this->freshTimestamp(),
        ])->save();
    }

    /**
     * @param string $token
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }


    /**
     * Lấy trường mật khẩu cuả user, ví dụ có thể lấy trường email ... làm mật khẩu - mặc định là $this->password
     * Lưu ý khi thay đổi trường này, hàng loạt các vấn đề liên quan sẽ phải thay đổi như: login, verify email ...
     * KHÔNG nên thay đổi.
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }
}

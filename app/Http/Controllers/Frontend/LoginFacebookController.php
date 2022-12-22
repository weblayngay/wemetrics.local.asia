<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\RedirectResponse;

class LoginFacebookController extends BaseController
{

    const ACCOUNT_TYPE = 'facebook';

    const PASSWORD = 'XQSAwTrzbce4Vo5nNDfc2yDlctsPVpNG3v6pclMb';

    /**
     * LoginFacebookController constructor.
     */
    public function __construct()
    {
        $this->middleware('guest')->except(['redirectToFacebook', 'handleFacebookCallback']);
    }

    /**
     * @return RedirectResponse
     */
    public function redirectToFacebook(): RedirectResponse
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleFacebookCallback(): \Illuminate\Http\RedirectResponse
    {
        try {
            $userOauth = Socialite::driver('facebook')->user();
            $user = User::parentQuery()
                ->where('oauth_id', $userOauth->id)
                ->where('type', self::ACCOUNT_TYPE)
                ->first();

            if ($user) {
                if ($user->status == 'inactive') {
                    return redirect()->route('login')->with('error', 'Tài khoản của bạn đã bị khóa');;
                }
                Auth::login($user, true);
                return redirect()->intended()->with('success', 'Đăng nhập thành công');
            } else {
                $user = User::parentQuery()->create([
                    'name' => $userOauth->getName(),
                    //'email' => $userOauth->getEmail(),
                    'oauth_id' => $userOauth->getId(),
                    'type' => self::ACCOUNT_TYPE,
                    'status' => 'activated',
                    'avatar' => $userOauth->getAvatar(),
                    'password' => Hash::make(self::PASSWORD),
                ]);

                Auth::login($user, true);
                return redirect()->intended()->with('success', 'Đăng nhập thành công');
            }
        }catch (Exception $e) {
            return redirect()->route('login')->with('error', 'Email này đã tồn tại');
        }

    }
}

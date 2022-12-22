<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Http\Controllers\Controller;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Class ForgotPasswordController
 * @package App\Http\Controllers\Auth
 */
class ForgotPasswordController extends Controller
{
    /**
     * @var User
     */
    private User $userModel;

    /**
     * @var PasswordReset
     */
    private PasswordReset $passwordResetModel;

    /**
     * ForgotPasswordController constructor.
     * @param User $userModel
     * @param PasswordReset $passwordResetModel
     */
    public function __construct(
        User $userModel,
        PasswordReset $passwordResetModel
    )
    {
        $this->userModel = $userModel;
        $this->passwordResetModel = $passwordResetModel;
    }

    /**
     * @return Application|Factory|View
     */
    public function showLinkRequestForm()
    {
        return view('password.email');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        $email = $request->post('email', null);
        /**
         * @var User $user
         */
        if ($user = $this->userModel::query()->where('email', $email)->first()) {
            $token =  hash_hmac('sha256', Str::random(40), 'NHT');
            try {
                $user->sendPasswordResetNotification($token);
            } catch (\Exception $exception) {
                return back()->with('send-email-failed', true);
            }

            /**
             * Remove user's 'password reset'
             */
            $this->passwordResetModel::query()->where('email', $email)->delete();

            /**
             * Create user's 'password reset'
             */
            $this->passwordResetModel::query()->create([
                'email' => $email,
                'token' => Hash::make($token)
            ]);

            return back()->with('send-email-successful', true);
        }

        return back()->with('reconfirm', true);
    }

}

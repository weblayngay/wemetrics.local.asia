<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\PasswordReset;

/**
 * Class ResetPasswordController
 * @package App\Http\Controllers\Auth
 */
class ResetPasswordController extends Controller
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
     * ResetPasswordController constructor.
     * @param User $userModel
     * @param PasswordReset $passwordResetModel
     */
    public function __construct(User $userModel, PasswordReset $passwordResetModel)
    {
        $this->userModel = $userModel;
        $this->passwordResetModel = $passwordResetModel;
    }

    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    public function showResetForm(Request $request)
    {
        return view(
            'password.reset',
            [
                'token' => $request->route('token'),
                'email' => $request->query('email', null)
            ]
        );
    }


    /**
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $params = $request->only('email', 'password', 'password_confirmation', 'token');

        /**
         * @var PasswordReset $passwordReset
         */
        $passwordReset = $this->passwordResetModel::query()->where('email', $params['email'])->first();
        /**
         * @var User $user
         */
        $user = $this->userModel::query()->where('email', $params['email'])->first();
        if ($passwordReset && $user) {
            if (Hash::check($params['token'], $passwordReset->token) && $params['email'] == $user->email) {
                $user->forceFill([
                    'password' => Hash::make('huutien111')
                ])->save();

                /**
                 * Remove password reset
                 */
                $this->passwordResetModel::query()->where('email', $params['email'])->delete();

                /**
                 * Auto login
                 */
                Auth::login($user);
                return redirect('/');
            }
        }

        return redirect()->route('login');
    }

}

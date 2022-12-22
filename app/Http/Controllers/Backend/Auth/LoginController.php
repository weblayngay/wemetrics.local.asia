<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Http\Controllers\Backend\BaseController;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends BaseController
{
    /**
     * @var string
     */
    private string $homePage = '/' . ADMIN_ROUTE;

    /**
     * @var string
     */
    private string $loginForm = ADMIN_ROUTE . '/login.htm';


    public function __construct()
    {
        $this->middleware('guest:admin')->except(['logout', 'logoutOtherDevices']);

    }

    /**
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     * @throws ValidationException
     */
    public function login(Request $request)
    {
        /**
         * Validate the form data
         */
        $this->validate($request, [
            'email'  => 'bail|required',
            'password'  => 'bail|required'
        ]);

        /**
         * Verify user
         */
        $credentials = $request->only('email', 'password');
        $rememberMe  = $request->get('remember-me') ? true : false;
        $success = 'Đăng nhập thành công.';
        $error   = 'Đăng nhập thất bại. Kiểm tra mật khẩu hoặc password';
        if (Auth::guard('admin')->attempt(array_merge($credentials, ['status' => 'activated', 'is_deleted' => 'no']), $rememberMe)) {
            $request->session()->regenerate();
            $_SESSION['ckfinder_auth'] = true;
            return redirect($this->homePage)->with('success', $success);
        }else{
            return redirect($this->loginForm)->with('error', $error);
        }
    }

    /**
     * @return RedirectResponse
     */
    public function logout(){
        // unset($_SESSION['ckfinder_auth']);
        Auth::guard('admin')->logout();
        return redirect($this->loginForm);
    }

    /**
     * @return Application|Factory|View|RedirectResponse|Redirector
     */
    public function loginForm()
    {
        return view($this->viewPath . '.login.login');
    }


    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function logoutOtherDevices(Request $request)
    {
        $password = $request->post('password', null);
        if (Hash::check($password, $request->user()->password)) {
            if (Auth::logoutOtherDevices($password)) {
                unset($_SESSION['ckfinder_auth']);
                return redirect('/');
            }
        }

        return back();
    }

}

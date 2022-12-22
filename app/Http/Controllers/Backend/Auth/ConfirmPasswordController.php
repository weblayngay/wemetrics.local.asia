<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Class ConfirmPasswordController
 * @package App\Http\Controllers
 */
class ConfirmPasswordController extends Controller
{
    private User $userModel;

    /**
     * ConfirmPasswordController constructor.
     * @param User $userModel
     */
    public function __construct(User $userModel)
    {
        $this->middleware('auth');
        $this->userModel = $userModel;
    }

    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    public function showConfirmForm(Request $request)
    {
        $request->session()->forget('url.intended');
        if ( back()->getRequest() instanceof Request ){
            $backRequest = back()->getRequest();
            if (
                Str::slug($backRequest->getPathInfo()) != Str::slug($request->route()->uri())
                && $backRequest->getMethod() == 'GET'
            ) {
                $request->session()->put('url.intended', back()->getTargetUrl());
            }
        }
        return view('password.confirm');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function confirm(Request $request)
    {
        $password = $request->get('password');
        if (Hash::check($password, $request->user()->password)) {
            $request->session()->put('auth.password_confirmed_at', time());
            return redirect()->intended('/');
        }
        return back()->with('reconfirm', true);
    }
}

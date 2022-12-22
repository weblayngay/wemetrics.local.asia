<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class VerificationController extends Controller
{
    protected string $homePage = '/';

    public function __construct(){
        $this->middleware('auth');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    /**
     * Gửi mail verify email
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function resend(Request $request) {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect($this->homePage);
        }
        $request->user()->sendEmailVerificationNotification();
        return back()->with('resent', true);
    }

    /**
     * @return Application|Factory|View
     */
    public function show()
    {
        return view('verification.show');
    }

    /**
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     * @throws AuthorizationException
     */
    public function verify(Request $request)
    {
        /**
         * Kiểm tra ID hiện đang đăng nhập có bằng id được verify hay không.
         */
        if (! hash_equals((string) $request->route('id'), (string) $request->user()->getKey())) {
            throw new AuthorizationException;
        }

        /**
         * Kiểm tra email người dùng hiện tại có khớp với email verify hay không.
         * hash trên route chính là email được mã hóa
         */
        if (! hash_equals((string) $request->route('hash'), sha1($request->user()->getEmailForVerification()))) {
            throw new AuthorizationException;
        }


        /**
         * Kiểm tra thời gian
         */
        if (time() > $request->query('expires', 0)) {
            throw new \Exception('Email authentication time has expired.');
        }


        if ($request->user()->hasVerifiedEmail()) {
            return redirect('/');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }
        return redirect('/')->with('verified', true);
    }
}

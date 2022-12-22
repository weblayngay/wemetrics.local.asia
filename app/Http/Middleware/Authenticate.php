<?php

namespace App\Http\Middleware;

use App\Models\AdminMenu;
use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Routing\Route;

class Authenticate extends Middleware
{
    private $login = 'login';


    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$guards
     * @return mixed
     *
     * @throws AuthenticationException
     */
    public function handle($request, Closure $next, ...$guards)
    {
        if (!defined('ADMIN_ROUTE')) {
            define('ADMIN_ROUTE', 'admins');
        }
        
        if (current($guards) == 'admin') {
            $this->login = ADMIN_ROUTE . '.login';
        }

        $this->authenticate($request, $guards);


        /**
         * Kiểm tra quyền người dùng đăng nhập vào trang admin
         */
        if (current($guards) == 'admin') {
            if ($this->checkPermissionAdmin($request) === false) {
                return abort(401);
                //return redirect(route(ADMIN_ROUTE . '.logout'));
            }
        }

        return $next($request);
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route($this->login);
        }
    }


    /**
     * @param Request $request
     * @return bool
     */
    private function checkPermissionAdmin(Request $request): bool
    {
        if (Auth::guard('admin')->check()) {
            $user = Auth::guard('admin')->user();
            if ($user->status != 'activated' || $user->is_deleted != 'no') {
                return false;
            } else {
                if ($this->checkRootAccountAdmin($user->aduser_id, $user->adgroup_id) === false) {
                    $adminMenuArr = array_filter(explode(',', $user->adminGroup->admenu_ids));
                    /**
                     * @var AdminMenu $adminUserModel
                     */
                    $adminMenuModel = app('AdminMenu');
                    $adminMenus   = $adminMenuModel::parentQuery()->where(['status' => 'activated'])->whereNotIn('admenu_id', $adminMenuArr)->get();
                    if (count($adminMenus) == 0) {
                        return true;
                    } else {
                        $params = $this->getActionAndController();
                        foreach ($adminMenus as $value) {
                            if (strtolower($params['controller']) == strtolower($value->controller) && strtolower($params['action']) == strtolower($value->action)) {
                                return false;
                            }
                        }
                    }
                }
                return true;
            }
        } else {
            return false;
        }
    }


    /**
     * @return array
     */
    private function getActionAndController(): array
    {
        /**
         * @var Request $request
         */
        $request    = app('request');
        $routeArray = $request->route()->getAction();


        $result = [];
        if (isset($routeArray['controller'])) {
            $result['action'] = strtolower($request->route()->getActionMethod());
            list($controller) = explode('@', class_basename($request->route()->getAction()['controller']));
            $result['controller'] = strtolower(str_replace('Controller', '', $controller));
        }else{
            $params = $request->route()->parameters();
            if (is_array($params) && count($params)) {
                $result['controller']   = strtolower($params['controller']);
                $result['action']       = strtolower($params['action']);
            } else {
                $result['controller']   = strtolower('index');
                $result['action']       = strtolower('index');
            }

        }
        return $result;
    }

    /**
     * @param $userId
     * @param $groupId
     * @return bool
     */
    private function checkRootAccountAdmin($userId, $groupId): bool
    {
        if (in_array($userId, ROOT_USER_IDS) && in_array($groupId, ROOT_GROUP_IDS)) {
            return true;
        }
        return false;
    }

}

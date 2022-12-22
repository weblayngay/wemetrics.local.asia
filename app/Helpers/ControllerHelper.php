<?php

namespace App\Helpers;

class ControllerHelper
{
    /**
     * @return array
     */
    public static function getActionAndController(): array
    {
        $routeArray = \request()->route()->getAction();

        $result = [];
        if (isset($routeArray['controller'])) {
            $result['action'] = strtolower(\request()->route()->getActionMethod());
            list($controller) = explode('@', class_basename(\request()->route()->getAction()['controller']));
            $result['controller'] = strtolower(str_replace('Controller', '', $controller));
        }else{
            $params = \request()->route()->parameters();
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
}

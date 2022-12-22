<?php
namespace App\Helpers;
use Illuminate\Support\Str; 

class UrlHelper
{

    /**
     * @param string $controllerName
     * @param string $actionName
     * @param array $queries
     * @return string
     */
    public static function admin(string $controllerName = 'index', string $actionName = 'index', array $queries = []): string
    {
        $query = http_build_query($queries);
        $route = route(ADMIN_ROUTE, ['controller' => $controllerName, 'action' => $actionName]);
        if ($query) {
            $route = $route .'?'. $query;
        }
        return $route;
    }


    /**
     * @param string $icon
     * @return string
     */
    public static function adminIcon(string $icon): string
    {
        return asset('/public/admin/dist/icons/' . $icon);
    }

    /**
     * @param string $icon
     * @return string
     */
    public static function pageUrl($name, $url): string
    {
        if(!empty($url))
        {
            $prefix = str::substr($url);
            if($prefix != str::slug($name))
            {
                $url = str::slug($name).SUFFIX_URL;
            }
        }
        else
        {
            $url = str::slug($name).SUFFIX_URL;
        }
        return $url;
    }

    /**
     * @param string $icon
     * @return string
     */
    public static function postSlug($name, $slug): string
    {
        if(!empty($slug))
        {
            $lengthSlug = strlen($slug);
            $prefix = str::substr($slug, $lengthSlug - 5);
            $suffix = str::substr($slug, - 5);
            if($prefix != str::slug($name))
            {
                $slug = str::slug($name) . '-' . $suffix;
            }
        }
        else
        {
            $slug = str::slug($name).'-'.Str::substr(sha1(time()), 1, 5);
        }
        return $slug;
    }

    /**
     * @param string $icon
     * @return string
     */
    public static function postUrl($name, $url): string
    {
        if(!empty($url))
        {
            $lengthSlug = strlen($url);
            $prefix = str::substr($url, $lengthSlug - 5);
            $suffix = str::substr($url, - 5);
            if($prefix != str::slug($name))
            {
                $url = str::slug($name) . '-' . $suffix.SUFFIX_URL;
            }
        }
        else
        {
            $url = str::slug($name).'-'.Str::substr(sha1(time()), 1, 5).SUFFIX_URL;
        }
        return $url;
    }

    /**
     * @param string $icon
     * @return string
     */
    public static function code($name, $code): string
    {
        if(!empty($code))
        {
            $lengthSlug = strlen($code);
            $prefix = str::substr($code, $lengthSlug - 5);
            $suffix = str::substr($code, - 5);
            if($prefix != str::slug($name))
            {
                $code = str::slug($name) . '-' . $suffix;
            }
        }
        else
        {
            $code = strtoupper(str::slug($name).'-'.Str::substr(sha1(time()), 1, 5));
        }
        return $code;
    }

    /**
     * @param string $icon
     * @return string
     */
    public static function slug($name, $slug): string
    {
        if(!empty($slug))
        {
            $lengthSlug = strlen($slug);
            $prefix = str::substr($slug, $lengthSlug - 5);
            $suffix = str::substr($slug, - 5);
            if($prefix != str::slug($name))
            {
                $slug = str::slug($name) . '-' . $suffix;
            }
        }
        else
        {
            $slug = str::slug($name).'-'.Str::substr(sha1(time()), 1, 5);
        }
        return $slug;
    }

    /**
     * @param string $icon
     * @return string
     */
    public static function campaignSlug($name, $slug): string
    {
        if(!empty($slug))
        {
            $lengthSlug = strlen($slug);
            $prefix = str::substr($slug, $lengthSlug - 5);
            $suffix = str::substr($slug, - 5);
            if($prefix != str::slug($name))
            {
                $slug = str::slug($name) . '-' . $suffix;
            }
        }
        else
        {
            $slug = str::slug($name).'-'.Str::substr(sha1(time()), 1, 5);
        }
        return $slug;
    }

    /**
     * @param string $icon
     * @return string
     */
    public static function campaignUrl($name, $url): string
    {
        if(!empty($url))
        {
            $lengthSlug = strlen($url);
            $prefix = str::substr($url, $lengthSlug - 5);
            $suffix = str::substr($url, - 5);
            if($prefix != str::slug($name))
            {
                $url = str::slug($name) . '-' . $suffix.SUFFIX_URL;
            }
        }
        else
        {
            $url = str::slug('campaign-'.$name).'-'.Str::substr(sha1(time()), 1, 5).SUFFIX_URL;
        }
        return $url;
    }
}

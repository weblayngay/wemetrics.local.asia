<?php

namespace App\Providers;

use App\Helpers\ArrayHelper;
use App\Helpers\CaptchaHelper;
use App\Helpers\ControllerHelper;
use App\Helpers\NestedSetModelHelper;
use App\Helpers\UrlHelper;
use App\Models\AdminMenu;
use App\Models\AdminUser;
use App\Models\Banner;
use App\Models\Config;
use App\Models\Menu;
use App\Models\PerceivedValue;
use App\Models\Post;
use App\Models\Product;
use App\Models\ProductCategory;
use Carbon\Carbon;
use Illuminate\Database\Events\TransactionBeginning;
use Illuminate\Database\Events\TransactionCommitted;
use Illuminate\Database\Events\TransactionRolledBack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use DateTime;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        /**
         * Helpers
         */
        $this->app->bind('ArrayHelper', ArrayHelper::class);
        $this->app->bind('UrlHelper', UrlHelper::class);
        $this->app->bind('NestedSetModelHelper', NestedSetModelHelper::class);
        $this->app->bind('Captcha', CaptchaHelper::class);
        $this->app->bind('ControllerHelper', ControllerHelper::class);


        /**
         * Models
         */
        $this->app->bind('AdminMenu', AdminMenu::class);
        $this->app->bind('Post', Post::class);
        $this->app->bind('Product', Product::class);
        $this->app->bind('Config', Config::class);
        $this->app->bind('Menu', Menu::class);
        $this->app->bind('AdminUser', AdminUser::class);
        $this->app->bind('Banner', Banner::class);
        $this->app->bind('PerceivedValue', PerceivedValue::class);
        $this->app->bind('ProductCategory', ProductCategory::class);

    }

    /**
     * Bootstrap any application services.
     *
     * @param Request $request
     * @return void
     */
    public function boot(Request $request)
    {
        app()->setLocale('vi');
        /**
         * Listening For Query Events
         * https://laravel.com/docs/8.x/database#listening-for-query-events
         */
        if (config('logging.saving_all_database_query') === true) {
            DB::listen(function ($query) use ($request) {
                $sql = $query->sql;
                foreach ($query->bindings as $binding) {
                    if (is_string($binding)) {
                        $binding = "'{$binding}'";
                    } elseif ($binding === null) {
                        $binding = 'NULL';
                    } elseif ($binding instanceof Carbon) {
                        $binding = "'{$binding->toDateTimeString()}'";
                    } elseif ($binding instanceof DateTime) {
                        $binding = "'{$binding->format('Y-m-d H:i:s')}'";
                    }

                    $sql = preg_replace("/\?/", $binding, $sql, 1);
                }

                Log::channel('daily')->debug('SQL', ['url' => $request->url(), 'sql' => $sql, 'time' => "$query->time ms"]);
            });

            Event::listen(TransactionBeginning::class, function (TransactionBeginning $event) {
                Log::debug('START TRANSACTION');
            });

            Event::listen(TransactionCommitted::class, function (TransactionCommitted $event) {
                Log::debug('COMMIT');
            });

            Event::listen(TransactionRolledBack::class, function (TransactionRolledBack $event) {
                Log::debug('ROLLBACK');
            });
        }


        if (config('logging.enable_sql_log') === true) {
            $db = new \Illuminate\Database\Capsule\Manager;
            $db->addConnection(config('database.connections.mysql'));
            $db->getConnection()->enableQueryLog();
            $db->setAsGlobal();
            $db->bootEloquent();
        }
    }
}

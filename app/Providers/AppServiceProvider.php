<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('convert', function ($money) {
            return "<?php echo number_format($money, 2); ?>";
        });

        Blade::directive('getdecimals', function ($money) {
            $money2 = strval($money);
            $result = explode(".", $money2);
            return "<?php echo $result[0]";
        });

        date_default_timezone_set('America/Mexico_City');
        setlocale(LC_ALL, 'es_ES.UTF-8');
    }


}
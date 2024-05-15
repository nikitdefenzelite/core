<?php
/**
 *
 * @category ZStarter
 *
 * @ref     Defenzelite product
 * @author  <Defenzelite hq@defenzelite.com>
 * @license <https://www.defenzelite.com Defenzelite Private Limited>
 * @version <zStarter: 202309-V1.3>
 * @link    <https://www.defenzelite.com>
 */


namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Validator;

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
        Validator::extend('numeric_phone_length', function ($attribute, $value, $parameters, $validator) {
            $numericValue = preg_replace('/[^0-9]/', '', $value); // Remove non-numeric characters
            $length = strlen($numericValue);
            return $length >= $parameters[0] && $length <= $parameters[1];
        });
        Validator::replacer('numeric_phone_length', function ($message, $attribute, $rule, $parameters) {
            return str_replace([':min', ':max'], $parameters, $message);
        });
        Blade::component('components.badge', 'badge');
    }
}

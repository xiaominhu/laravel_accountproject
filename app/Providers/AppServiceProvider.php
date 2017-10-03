<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Schema;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
		
		 Validator::extend('foo', function ($attribute, $value, $parameters, $validator) {
            return $value == 'foo';
        });
		
		/*	*/
		Validator::replacer('foo', function ($message, $attribute, $rule, $parameters) {
			return str_replace("validation.foo","Please correct this.", $message);
		});
		
	
		Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
		
    }
}

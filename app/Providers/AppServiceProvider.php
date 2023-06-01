<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Jenssegers\Agent\Agent;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $navbar_inverse = false;
        $pages = [
            '/', 'influencers', 'advertisers',
            'influencers/apply/networks', 'influencers/apply/payment',
        ];
        foreach ($pages as $page) {
//            if (request()->path() == $page || starts_with(request()->path(), $page))
            if (request()->path() == $page)
                $navbar_inverse = true;
        }

        
        $is_mobile = false;
        $agent = new Agent();
        if($agent->isMobile() || $agent->isTablet())
            $is_mobile = true;

        view()->share('navbar_inverse', $navbar_inverse);
        view()->share('is_mobile', $is_mobile);
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

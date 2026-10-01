<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Setting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::useTailwind();

        View::composer('*', function ($view) {
            try {
                $view->with('siteSettings', [
                    'company_name' => Setting::get('company_name', 'AUTO-JAR'),
                    'company_tagline' => Setting::get('company_tagline', 'Votre pièce automobile, simplement.'),
                    'phone' => Setting::get('phone', '0522123456'),
                    'phone_display' => Setting::get('phone_display', '05 22 12 34 56'),
                    'mobile' => Setting::get('mobile', '0612345678'),
                    'mobile_display' => Setting::get('mobile_display', '06 12 34 56 78'),
                    'whatsapp' => Setting::get('whatsapp', '212612345678'),
                    'whatsapp_display' => Setting::get('whatsapp_display', '06 12 34 56 78'),
                    'email' => Setting::get('email', 'contact@pieceauto.ma'),
                    'address' => Setting::get('address', 'Boulevard Zerktouni, Casablanca'),
                    'city' => Setting::get('city', 'Casablanca'),
                    'hours' => Setting::get('hours', 'Lun–Sam : 09h00 – 19h00'),
                ]);
            } catch (\Throwable $e) {
                $view->with('siteSettings', [
                    'company_name' => 'AUTO-JAR',
                    'company_tagline' => 'Votre pièce automobile, simplement.',
                    'phone' => '0522123456',
                    'phone_display' => '05 22 12 34 56',
                    'mobile' => '0612345678',
                    'mobile_display' => '06 12 34 56 78',
                    'whatsapp' => '212612345678',
                    'whatsapp_display' => '06 12 34 56 78',
                    'email' => 'contact@pieceauto.ma',
                    'address' => 'Boulevard Zerktouni, Casablanca',
                    'city' => 'Casablanca',
                    'hours' => 'Lun–Sam : 09h00 – 19h00',
                ]);
            }
        });

        View::composer('layouts.app', function ($view) {
            try {
                $view->with('navCategories', Category::query()->where('is_active', true)->orderBy('sort_order')->limit(8)->get());
            } catch (\Throwable $e) {
                $view->with('navCategories', collect());
            }
        });
    }
}

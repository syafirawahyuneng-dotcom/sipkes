<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\SiteSetting;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Satu objek SEO per request: diisi controller, dirender sekali di <head>.
        $this->app->scoped(\App\Support\Seo::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share site_logo to all views
        View::composer('*', function ($view) {
            try {
                $siteLogo = SiteSetting::get('site_logo');
            } catch (\Throwable $e) {
                $siteLogo = null;
            }
            $view->with('siteLogo', $siteLogo);
        });

        // Kontak resmi untuk dropdown "Konsultasi Sekarang" di navbar
        // (sumber: tabel contact_info yang dikelola admin).
        View::composer('layouts.frontend', function ($view) {
            try {
                $info = \App\Models\ContactInfo::first();
            } catch (\Throwable $e) {
                $info = null;
            }

            $phone = $info?->phone ?: '0813-3551-2803';
            $email = $info?->email ?: 'vkes@polije.ac.id';
            $wa = preg_replace('/\D+/', '', (string) ($info?->whatsapp ?: $phone));
            if (str_starts_with($wa, '0')) {
                $wa = '62' . substr($wa, 1);
            }

            $view->with('navContact', [
                'phone' => $phone,
                'tel' => preg_replace('/[^\d+]+/', '', $phone),
                'email' => $email,
                'wa_url' => 'https://wa.me/' . $wa . '?text=' . rawurlencode('Halo V-Kes Polije, saya ingin konsultasi layanan SIP-Kes'),
            ]);
        });
    }
}

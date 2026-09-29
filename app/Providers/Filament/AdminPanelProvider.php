<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->topbar(false)
            ->darkMode(false)
            ->brandName('Admin Piket')
            ->font('Inter')
            ->colors([
                'primary' => Color::Slate,
                'gray' => Color::Zinc,
            ])
            ->renderHook(
                'panels::sidebar.footer',
                fn (): string => '<div style="padding: 1rem; text-align: center;"><a href="'.url('/dashboard').'" style="display: inline-block; padding: 0.35rem 0.75rem; margin-bottom: 0.75rem; font-size: 0.75rem; color: #4b5563; background: #e5e7eb; border-radius: 0.375rem; text-decoration: none; font-weight: 600;">← Ke Dashboard Piket</a><img src="'.asset('images/admin_hero.png').'" alt="Admin" style="width: 100%; max-width: 180px; height: auto; margin: 0 auto; display: block; opacity: 0.9;"></div><style>.fi-sidebar-user-menu, .fi-sidebar-user { display: none !important; }</style>'
            )
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}

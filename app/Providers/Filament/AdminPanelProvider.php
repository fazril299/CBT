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
                'primary' => Color::Blue,
                'gray' => Color::Zinc,
            ])
            ->renderHook(
                'panels::sidebar.footer',
                fn (): string => '
                    <div style="padding: 1rem; text-align: center;">
                        <a href="'.url('/dashboard').'" style="display: inline-block; padding: 0.35rem 0.75rem; margin-bottom: 0.75rem; font-size: 0.75rem; color: #4b5563; background: #e5e7eb; border-radius: 0.375rem; text-decoration: none; font-weight: 600;">? Ke Dashboard Piket</a>
                        <img src="'.asset('images/admin_hero.png').'" alt="Admin" style="width: 100%; max-width: 180px; height: auto; margin: 0 auto; display: block; opacity: 0.9;">
                    </div>
                    <style>
                        /* Notion Global Styles */
                        body, .fi-body {
                            background-color: #ffffff !important;
                            color: #37352f !important;
                            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif !important;
                        }

                        /* Notion Sidebar (Off-white #f7f7f5) */
                        aside.fi-sidebar, .fi-sidebar {
                            background-color: #f7f7f5 !important;
                            border-right: 1px solid #edece9 !important;
                            box-shadow: none !important;
                        }

                        .fi-sidebar-header a, .fi-sidebar-header span {
                            color: #37352f !important;
                            font-weight: 700 !important;
                        }

                        .fi-sidebar-item-btn {
                            border-radius: 6px !important;
                            color: #37352f !important;
                            margin: 2px 8px !important;
                            padding: 6px 10px !important;
                            font-weight: 500 !important;
                        }

                        .fi-sidebar-item-btn:hover {
                            background-color: rgba(55, 53, 47, 0.05) !important;
                        }

                        .fi-sidebar-item-active .fi-sidebar-item-btn,
                        .fi-sidebar-item-btn.fi-active {
                            background-color: rgba(55, 53, 47, 0.08) !important;
                            color: #37352f !important;
                            font-weight: 600 !important;
                        }

                        /* TOMBOL PERSIS NOTION "New page" (Biru Solid + Teks PUTIH) */
                        .fi-btn-color-primary,
                        button.fi-btn-color-primary,
                        a.fi-btn-color-primary,
                        .fi-header-actions .fi-btn,
                        .fi-header-actions button,
                        .fi-header-actions a {
                            background-color: #2383e2 !important;
                            background: #2383e2 !important;
                            border-radius: 6px !important;
                            border: none !important;
                            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.08) !important;
                            padding: 6px 14px !important;
                        }

                        .fi-btn-color-primary:hover,
                        .fi-header-actions .fi-btn:hover {
                            background-color: #1a73ca !important;
                            background: #1a73ca !important;
                        }

                        /* Paksa Teks dan Ikon Tombol Putih 100% */
                        .fi-btn-color-primary *,
                        .fi-btn-color-primary span,
                        .fi-btn-color-primary .fi-btn-label,
                        .fi-header-actions .fi-btn *,
                        .fi-header-actions .fi-btn span,
                        .fi-header-actions .fi-btn .fi-btn-label {
                            color: #ffffff !important;
                            fill: #ffffff !important;
                            font-weight: 500 !important;
                            font-size: 14px !important;
                        }

                        /* Notion Tables */
                        .fi-ta-ctn {
                            background-color: #ffffff !important;
                            border: 1px solid #edece9 !important;
                            border-radius: 8px !important;
                            box-shadow: none !important;
                        }

                        .fi-ta-header-cell {
                            background-color: #fbfbfa !important;
                            color: rgba(55, 53, 47, 0.65) !important;
                            font-weight: 500 !important;
                            border-bottom: 1px solid #edece9 !important;
                        }

                        .fi-ta-row {
                            border-bottom: 1px solid rgba(55, 53, 47, 0.09) !important;
                        }

                        .fi-ta-row:hover {
                            background-color: rgba(55, 53, 47, 0.025) !important;
                        }

                        .fi-ta-cell, .fi-ta-text-item-label {
                            color: #37352f !important;
                        }

                        /* Search & Inputs */
                        .fi-input-wrp {
                            background-color: #ffffff !important;
                            border: 1px solid #edece9 !important;
                            border-radius: 6px !important;
                            box-shadow: none !important;
                        }

                        .fi-sidebar-user-menu, .fi-sidebar-user {
                            display: none !important;
                        }
                    </style>
                '
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

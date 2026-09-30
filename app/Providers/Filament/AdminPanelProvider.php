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
                'primary' => '#2383e2', // Warna Biru Notion
                'gray' => Color::Zinc,
            ])
                        ->renderHook(
                \Filament\View\PanelsRenderHook::HEAD_END,
                fn (): string => '
                <style>
                    /* Notion Palette & Aesthetic */
                    :root {
                        --notion-bg: #ffffff;
                        --notion-sidebar: #f7f7f5;
                        --notion-text: #37352f;
                        --notion-text-muted: rgba(55, 53, 47, 0.65);
                        --notion-border: #edece9;
                        --notion-border-light: rgba(55, 53, 47, 0.09);
                        --notion-hover: rgba(55, 53, 47, 0.05);
                        --notion-active: rgba(55, 53, 47, 0.08);
                        --notion-blue: #2383e2;
                        --notion-blue-hover: #1d70c2;
                    }

                    body, .fi-body {
                        background-color: var(--notion-bg) !important;
                        color: var(--notion-text) !important;
                        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Helvetica, "Apple Color Emoji", Arial, sans-serif !important;
                    }

                    /* Notion Sidebar (Off-white warm gray #f7f7f5) */
                    aside.fi-sidebar, .fi-sidebar {
                        background-color: var(--notion-sidebar) !important;
                        border-right: 1px solid var(--notion-border) !important;
                        box-shadow: none !important;
                    }

                    .fi-sidebar-header {
                        border-bottom: 1px solid transparent !important;
                        padding-top: 1.25rem !important;
                        padding-bottom: 0.75rem !important;
                    }

                    .fi-sidebar-header a, .fi-sidebar-header span {
                        color: var(--notion-text) !important;
                        font-weight: 700 !important;
                        letter-spacing: -0.02em !important;
                        font-size: 1rem !important;
                    }

                    /* Sidebar Navigation Items */
                    .fi-sidebar-item-btn {
                        border-radius: 6px !important;
                        color: var(--notion-text) !important;
                        transition: background-color 0.1s ease, color 0.1s ease !important;
                        margin: 2px 8px !important;
                        padding: 6px 10px !important;
                        font-weight: 500 !important;
                        font-size: 0.875rem !important;
                    }

                    .fi-sidebar-item-btn:hover {
                        background-color: var(--notion-hover) !important;
                        color: var(--notion-text) !important;
                    }

                    .fi-sidebar-item-active .fi-sidebar-item-btn,
                    .fi-sidebar-item-btn.fi-active {
                        background-color: var(--notion-active) !important;
                        color: var(--notion-text) !important;
                        font-weight: 600 !important;
                    }

                    .fi-sidebar-item-icon {
                        color: var(--notion-text-muted) !important;
                    }

                    .fi-sidebar-item-active .fi-sidebar-item-icon {
                        color: var(--notion-text) !important;
                    }

                    /* Main Page Content Area */
                    main.fi-main, .fi-main {
                        background-color: var(--notion-bg) !important;
                    }

                    /* Notion Headings */
                    h1, .fi-header-heading {
                        color: var(--notion-text) !important;
                        font-weight: 700 !important;
                        letter-spacing: -0.03em !important;
                    }

                    /* Notion Table Container */
                    .fi-ta-ctn {
                        background-color: var(--notion-bg) !important;
                        border: 1px solid var(--notion-border) !important;
                        border-radius: 8px !important;
                        box-shadow: none !important;
                        overflow: hidden !important;
                    }

                    /* Notion Table Header */
                    .fi-ta-header-cell {
                        background-color: #fbfbfa !important;
                        color: var(--notion-text-muted) !important;
                        font-weight: 500 !important;
                        font-size: 0.775rem !important;
                        border-bottom: 1px solid var(--notion-border) !important;
                        text-transform: capitalize !important;
                    }

                    /* Notion Table Rows */
                    .fi-ta-row {
                        border-bottom: 1px solid var(--notion-border-light) !important;
                        transition: background-color 0.1s ease !important;
                    }

                    .fi-ta-row:hover {
                        background-color: rgba(55, 53, 47, 0.025) !important;
                    }

                    .fi-ta-cell, .fi-ta-text-item-label {
                        color: var(--notion-text) !important;
                        font-size: 0.875rem !important;
                    }

                    /* Notion Buttons (Exact match to Notion "New page") */
                    .fi-btn-color-primary,
                    a.fi-btn-color-primary,
                    button.fi-btn-color-primary,
                    .fi-ac-action.fi-btn-color-primary {
                        background-color: #2383e2 !important;
                        background: #2383e2 !important;
                        border: none !important;
                        border-radius: 6px !important;
                        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05) !important;
                        padding: 6px 14px !important;
                        transition: background-color 0.12s ease !important;
                    }

                    .fi-btn-color-primary:hover,
                    a.fi-btn-color-primary:hover,
                    button.fi-btn-color-primary:hover {
                        background-color: #1a73ca !important;
                        background: #1a73ca !important;
                    }

                    /* Paksa semua teks & ikon di dalam tombol menjadi PUTIH BERSIH persis Notion */
                    .fi-btn-color-primary *,
                    .fi-btn-color-primary .fi-btn-label,
                    .fi-btn-color-primary span,
                    .fi-btn-color-primary svg {
                        color: #ffffff !important;
                        fill: #ffffff !important;
                        font-weight: 500 !important;
                        letter-spacing: -0.01em !important;
                    }

                    /* Search & Inputs */
                    .fi-input-wrp {
                        background-color: var(--notion-bg) !important;
                        border: 1px solid var(--notion-border) !important;
                        border-radius: 6px !important;
                        box-shadow: none !important;
                    }

                    .fi-input-wrp:focus-within {
                        border-color: var(--notion-blue) !important;
                        box-shadow: 0 0 0 2px rgba(35, 131, 226, 0.2) !important;
                    }

                    /* Badges Notion Style */
                    .fi-badge {
                        border-radius: 4px !important;
                        font-weight: 500 !important;
                        font-size: 0.75rem !important;
                        padding: 2px 6px !important;
                    }
                </style>
                '
            )
            ->renderHook('panels::sidebar.footer',
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




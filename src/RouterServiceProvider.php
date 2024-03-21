<?php

declare(strict_types=1);

namespace Sellarix\Router;


use Filament\Facades\Filament;
use Filament\Panel;
use Sellarix\Router\Filament\RouterPlugin;
use Sellarix\Router\Middleware\DatabaseRouter;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class RouterServiceProvider extends PackageServiceProvider {

    public function configurePackage(Package $package): void
    {
        $package
            ->name('router')
            ->hasRoute('web')
            ->hasMigrations(['create_routes_table', 'update_routes_table'])

            ->runsMigrations();
    }

    public function packageRegistered()
    {
        if (class_exists(Filament::class)) {
            Filament::registerPanel(
                fn(): Panel => Filament::getPanel('default')
                    ->plugin(RouterPlugin::make()),
            );
        }
    }
}

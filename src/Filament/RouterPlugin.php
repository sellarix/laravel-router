<?php

namespace Sellarix\Router\Filament;

use Filament\Contracts\Plugin;
use Filament\Facades\Filament;
use Filament\Navigation\NavigationGroup;
use Filament\Panel;
use ReflectionClass;
use Sellarix\Blog\Filament\Admin\Resources\CategoriesResource;
use Sellarix\Blog\Filament\Admin\Resources\PostsResource;
use Sellarix\Blog\Filament\Admin\Resources\PostTypesResource;
use Sellarix\Router\Filament\Router\Resources\RouterResource;

class RouterPlugin implements Plugin
{
    public function getId(): string
    {
        return 'router';
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public function register(Panel $panel): void
    {
        $panel
            ->resources([
                RouterResource::class
            ])
            ->navigationGroups([
                NavigationGroup::make()
                    ->label('Settings')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->collapsible(false),
            ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }
}

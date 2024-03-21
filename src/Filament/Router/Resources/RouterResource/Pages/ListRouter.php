<?php

namespace Sellarix\Router\Filament\Router\Resources\RouterResource\Pages;

use Sellarix\Blog\Filament\Admin\Resources\PostsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Sellarix\Router\Filament\Router\Resources\RouterResource;

class ListRouter extends ListRecords
{
    protected static string $resource = RouterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

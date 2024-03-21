<?php

namespace Sellarix\Router\Filament\Router\Resources;

use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Sellarix\Router\Filament\Router\Resources\RouterResource\Pages\ListRouter;
use Sellarix\Router\Models\Route;

class RouterResource extends Resource
{
    protected static ?string $model = Route::class;

    protected static ?string $slug = "router";

    protected static ?string $navigationGroup = 'Settings';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('url')->wrap(),
                TextColumn::make('method_type'),
                TextColumn::make('redirect'),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRouter::route('/'),
        ];
    }
}


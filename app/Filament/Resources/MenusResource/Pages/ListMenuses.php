<?php

namespace App\Filament\Resources\MenusResource\Pages;

use App\Filament\Resources\MenusResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMenuses extends ListRecords
{
    protected static string $resource = MenusResource::class;

    protected static ?string $title = 'Menu';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label('Add New Menu'),

        ];

        
    }
}

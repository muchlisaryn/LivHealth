<?php

namespace App\Filament\Resources\OrderCookingResource\Pages;

use App\Filament\Resources\OrderCookingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOrderCookings extends ListRecords
{
    protected static string $resource = OrderCookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}

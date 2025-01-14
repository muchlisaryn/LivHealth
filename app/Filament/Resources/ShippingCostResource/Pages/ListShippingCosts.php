<?php

namespace App\Filament\Resources\ShippingCostResource\Pages;

use App\Filament\Resources\ShippingCostResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListShippingCosts extends ListRecords
{
    protected static string $resource = ShippingCostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

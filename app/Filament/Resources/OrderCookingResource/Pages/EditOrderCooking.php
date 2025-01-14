<?php

namespace App\Filament\Resources\OrderCookingResource\Pages;

use App\Filament\Resources\OrderCookingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOrderCooking extends EditRecord
{
    protected static string $resource = OrderCookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}

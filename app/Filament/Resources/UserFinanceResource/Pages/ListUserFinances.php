<?php

namespace App\Filament\Resources\UserFinanceResource\Pages;

use App\Filament\Resources\UserFinanceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUserFinances extends ListRecords
{
    protected static string $resource = UserFinanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

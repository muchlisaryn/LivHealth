<?php

namespace App\Filament\Resources\UserFinanceResource\Pages;

use App\Filament\Resources\UserFinanceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUserFinance extends EditRecord
{
    protected static string $resource = UserFinanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\TransactionPaymentResource\Pages;

use App\Filament\Resources\TransactionPaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTransactionPayment extends EditRecord
{
    protected static string $resource = TransactionPaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}

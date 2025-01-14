<?php

namespace App\Filament\Resources\TransactionPaymentResource\Pages;

use App\Filament\Resources\TransactionPaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTransactionPayments extends ListRecords
{
    protected static string $resource = TransactionPaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\BankNameResource\Pages;

use App\Filament\Resources\BankNameResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBankNames extends ListRecords
{
    protected static string $resource = BankNameResource::class;

    protected static ?string $title = 'Bank';

    protected function getHeaderActions(): array
    {
        return [
          
        ];
    }
}

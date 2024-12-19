<?php

namespace App\Filament\Resources\BankNameResource\Pages;

use App\Filament\Resources\BankNameResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBankName extends CreateRecord
{
    protected static string $resource = BankNameResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

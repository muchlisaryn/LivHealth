<?php

namespace App\Filament\Resources\ProgramPlansResource\Pages;

use App\Filament\Resources\ProgramPlansResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProgramPlans extends ListRecords
{
    protected static string $resource = ProgramPlansResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}

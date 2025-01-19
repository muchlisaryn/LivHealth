<?php

namespace App\Filament\Resources\ProgramPlansResource\Pages;

use App\Filament\Resources\ProgramPlansResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProgramPlans extends EditRecord
{
    protected static string $resource = ProgramPlansResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}

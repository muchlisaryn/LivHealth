<?php

namespace App\Filament\Resources\WeeklyScheduleResource\Pages;

use App\Filament\Resources\WeeklyScheduleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWeeklySchedule extends EditRecord
{
    protected static string $resource = WeeklyScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}

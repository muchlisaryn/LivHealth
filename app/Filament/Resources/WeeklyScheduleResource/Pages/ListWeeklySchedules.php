<?php

namespace App\Filament\Resources\WeeklyScheduleResource\Pages;

use App\Filament\Resources\WeeklyScheduleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWeeklySchedules extends ListRecords
{
    protected static string $resource = WeeklyScheduleResource::class;

    protected static bool $hasBreadcrumbs = false;

    protected static ?string $title = 'Weekly Schedules';

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}

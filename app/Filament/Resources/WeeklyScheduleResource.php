<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WeeklyScheduleResource\Pages;
use Filament\Notifications\Notification;
use App\Models\Menus;
use App\Models\WeeklySchedule;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WeeklyScheduleResource extends Resource
{
    protected static ?string $model = WeeklySchedule::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Ahli Gizi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
               
                Forms\Components\DatePicker::make('start_date')
                ->minDate(now()->startOfDay())
                ->required()
                ->reactive(),
                Forms\Components\DatePicker::make('end_date')
                ->reactive() // Re-render the component when the value of start_date changes
                ->disabled(fn ($get) => !$get('start_date')) // Disable end_date if start_date is not selected
                ->minDate(fn ($get) => $get('start_date') ? Carbon::parse($get('start_date'))->addDay() : null) // Set minimum date for end_date to be +1 day after start_date
                ->required()
                ->afterStateUpdated(function (callable $set, $state, $get) {
                    if (!$get('start_date')) {
                        $set(null); // Clear end_date when start_date is not selected
                    }
                }),
                Forms\Components\Select::make('status')
                ->options(
                        [
                            'Active' => 'Active',
                            'Non Active' => 'Non Active'
                        ]
                    )
                ->columnSpanFull()
                ->default('Active')
                ->required(),
                Forms\Components\Select::make('menu_id')
                    ->label('menu')
                    ->multiple()
                    ->searchable()
                    ->required()
                    ->options(
                        Menus::query()
                        ->pluck('name', 'id')
                        ->toArray()
                    )
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('start_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')->badge()->color(fn(string $state) : string => match($state) {
                    'Active' => 'success',
                    'Not Active' => 'danger'
                })
            ])
            ->filters([
                // Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                ->button(),

                Action::make('Set Inactive')
                ->button()
                ->color('danger')
                ->requiresConfirmation()
                ->action(function (WeeklySchedule $schedule) {
                   try {
                
                    $schedule->update([
                        'status' => 'Not Active'
                    ]);

                    Notification::make()->success('Schedule Deactivated')->body('The schedule has been successfully set to "Not Active".')->icon('heroicon-o-x-circle')->send();
                   } catch (\Exception $e){
                    Notification::make()->danger()->body('Error: ' . $e->getMessage())->send();
                   }
                   
                })
                // ->hidden(fn (WeeklySchedule $schedule) => $schedule->status != 'Active')
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                //     Tables\Actions\ForceDeleteBulkAction::make(),
                //     Tables\Actions\RestoreBulkAction::make(),
                // ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWeeklySchedules::route('/'),
            'create' => Pages\CreateWeeklySchedule::route('/create'),
            'edit' => Pages\EditWeeklySchedule::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}

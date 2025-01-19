<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProgramPlansResource\Pages;
use App\Models\Menus;
use Filament\Notifications\Notification;
use App\Models\ProgramPlans;
use App\Models\Programs;
use App\Models\Transaction;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProgramPlansResource extends Resource
{
    protected static ?string $model = ProgramPlans::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Ahli Gizi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('transaction_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('status')
                    ->required(),
                Forms\Components\DatePicker::make('start_date'),
                Forms\Components\DatePicker::make('end_date'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('transaction_id')
                    ->label("No Transaction")
                    ->prefix("#")
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('transaction.programs.name')
                    ->label("Program")
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('transaction.programs.duration_days')
                    ->label("Durasi")
                    ->numeric()
                    ->formatStateUsing(fn ($state) => $state . ' Days')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')->badge()->color(fn(string $state) : string => match($state) {
                    'Pending' => 'gray',
                    'In Progress' => 'warning',
                    'Completed' => 'success',
                    'Canceled' => 'danger'
                    })
                    ->alignCenter()
                    ->label('Status Program'),
                Tables\Columns\TextColumn::make('start_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->date()
                    ->sortable(),        
            ])
            ->filters([
                
            ])
            ->actions([
                Action::make('Start')
                ->button()
                ->color('success')
                ->requiresConfirmation()
                ->action(function(ProgramPlans $program){

                    $duration = $program->transaction->programs->duration_days;

                    if($duration) {
                        $start_date = Carbon::today();
                        $end_date = $start_date->copy()->addDays($duration);

                        ProgramPlans::find($program->id)->update([
                            'status' => 'In Progress',
                            'start_date' => $start_date->toDateString(),
                            'end_date' => $end_date->toDateString(),
                        ]);

                        Notification::make()->success('Program Created Successfully!')->body('The new program has been successfully created.')->icon('heroicon-o-check')->send();
                    }
                })
                ->hidden(fn(ProgramPlans $program) => $program->status != 'Pending'),
                
                Action::make('Order')
                ->button()
                ->color('info')
                ->requiresConfirmation()
                ->form([
                    Forms\Components\Select::make('menu_id')
                        ->label('Menu')
                        ->required()
                        // ->searchable()
                        ->options(function ($get) {
                            $transactionId = $get('transaction_id');

                            if(!$transactionId) {
                                return[];
                            }

                            $transaction = Transaction::find($transactionId);

                            if(!$transaction || !$transaction->program) {
                                return [];
                            }

                            return Menus::whereIn('id', $transaction->program->menu_id)
                            ->pluck('name', 'id');

                        })
                      
                ])
                ->hidden(fn(ProgramPlans $program) => $program->status != 'In Progress')
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                 
                ]),
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
            'index' => Pages\ListProgramPlans::route('/'),
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

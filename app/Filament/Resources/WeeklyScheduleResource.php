<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WeeklyScheduleResource\Pages;
use App\Models\Categories;
use App\Models\Menus;
use Filament\Notifications\Notification;

use App\Models\WeeklySchedule;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WeeklyScheduleResource extends Resource
{
    protected static ?string $model = Categories::class;

    protected static ?string $navigationLabel = 'Weekly Schedules';


    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Ahli Gizi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([ 
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Category')
                    ->searchable(),
                Tables\Columns\TextColumn::make('schedule.menu')
                    ->label('menu')
                    ->getStateUsing(function ($record) {
                        $menuIds = WeeklySchedule::where('category_id', $record->id)
                        ->pluck('menu_id') // Ambil menu_id yang terkait dengan category_id
                        ->flatten() // Pastikan array dalam bentuk tunggal
                        ->unique(); // Hanya mengambil menu_id yang unik

                        // Ambil nama-nama menu berdasarkan menu_id yang ditemukan
                        $menus = Menus::whereIn('id', $menuIds)
                                    ->pluck('name')
                                    ->toArray();

                        // Gabungkan nama-nama menu menjadi satu string yang dipisahkan dengan koma
                        return implode(', ', $menus);
                    })
                  
            ])
            ->filters([
                // Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                // Tables\Actions\EditAction::make()
                // ->button(),

                Action::make('Edit Menu')
                ->button()
                ->color('warning')
                ->requiresConfirmation()
                ->form([
                    Select::make('menu_id')
                    ->label('Menu')
                    ->required()
                    ->searchable()
                    ->multiple()
                    ->options(function($record) {
                        // Fetch menus based on category_id
                        $category_id = (string)$record->id;

                        $menus = Menus::whereJsonContains('category_id', $category_id)->get();
                       
                        if ($menus->isEmpty()) {
                            return []; 
                        }
                        
                        return $menus->pluck('name', 'id')->toArray();
                    })
                    ->default(function($record) {
                        $result = WeeklySchedule::where('category_id' , $record->id)->first();
                        
                        if ($result && $result->menu_id) {
                            // Pastikan menu_id adalah array, bisa menggunakan json_decode jika data dalam format JSON
                            return is_array($result->menu_id) ? $result->menu_id : json_decode($result->menu_id, true);
                        }
        
                        return [];  // Kembalikan array kosong jika tidak ada menu_id
                    })
                ])
                ->action(function(Categories $category, array $data) {
                    try {
                        $schedule = $category->schedule;

                        $schedule->update([
                            'menu_id' => $data['menu_id']
                        ]);
                    }catch (\Exception $e){
                        Notification::make()->danger()->body('Error: ' . $e->getMessage())->send();
                    }
                })
                ->hidden(function($record) {
                    $findWeeklySchedules = WeeklySchedule::where('category_id' , $record->id)->exists();
                  
                    if($findWeeklySchedules){
                        return false;
                    }else{
                        return true;
                    }
                }),

                Action::make('Pilih Menu')
                ->button()
                ->color('success')
                ->requiresConfirmation()
                ->form([
                    Select::make('menu_id')
                    ->label('Menu')
                    ->required()
                    ->searchable()
                    ->multiple()
                    ->options(function($record) {
                        // Fetch menus based on category_id
                        $category_id = (string)$record->id;

                        $menus = Menus::whereJsonContains('category_id', $category_id)->get();
                       
                        if ($menus->isEmpty()) {
                            return []; 
                        }
                        
                        return $menus->pluck('name', 'id')->toArray();
                    })
                    ->rules('max:2') 
                    ->helperText('Pilih maksimal 2 menu')
                ])
                ->action(function($record, WeeklySchedule $schedule, array $data) {
                    try {
                        $schedule->create([
                            'category_id' => $record->id,
                            'menu_id' => $data['menu_id']
                        ]);
                    }catch (\Exception $e){
                        Notification::make()->danger()->body('Error: ' . $e->getMessage())->send();
                    }
                })
                ->hidden(function($record) {

                    $findWeeklySchedules = WeeklySchedule::where('category_id' , $record->id)->exists();
                  
                    if($findWeeklySchedules){
                        return true;
                    }else{
                        return false;
                    }
                })
                

                
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
            // 'create' => Pages\CreateWeeklySchedule::route('/create'),
            // 'edit' => Pages\EditWeeklySchedule::route('/{record}/edit'),
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

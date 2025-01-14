<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderCookingResource\Pages;
use App\Filament\Resources\OrderCookingResource\RelationManagers;
use App\Models\OrderCooking;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderCookingResource extends Resource
{
    protected static ?string $model = OrderCooking::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Koki';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('transaction_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('status')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('transaction.id')
                    ->label('No Transaction')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('transaction.user.name')
                    ->label('Customer'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()->color(fn(string $state) : string => match($state) {
                        'In Progress' => 'gray',
                        'On Hold' => 'gray',
                        'New' => 'success',
                        'Ready for Pickup' => 'info',
                    })
            ])
            ->filters([
                // Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListOrderCookings::route('/'),
            'create' => Pages\CreateOrderCooking::route('/create'),
            'edit' => Pages\EditOrderCooking::route('/{record}/edit'),
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

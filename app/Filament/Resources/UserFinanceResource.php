<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserFinanceResource\Pages;
use App\Models\BankName;
use App\Models\User;
use App\Models\UserFinance;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class UserFinanceResource extends Resource
{
    protected static ?string $model = UserFinance::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    protected static ?string $navigationTitle = 'User Finance';

    protected static ?string $navigationGroup = 'Finance';

       public static function canAccess(): bool
    {
        return Auth::check() && Auth::user()->role === 'finance';
    }

    public static function canView(Model $record): bool
    {
        return Auth::user()->role === 'finance';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('users_id')
                    ->label('User')
                    ->columnSpanFull()
                    ->required()
                    ->options(
                        User::query()
                        ->pluck('name', 'id')
                    ),
                Forms\Components\Select::make('bank_name_id')
                    ->label('Bank Name')
                    ->required()
                    ->columnSpanFull()
                    ->options(
                        BankName::query()
                        ->pluck('name', 'id')
                    ),
                Forms\Components\TextInput::make('bank_account')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('bank_account_name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('users.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('bank_name.name')
                    ->label("Bank Name")
                    ->searchable(),
                Tables\Columns\TextColumn::make('bank_account')
                    ->searchable(),
                Tables\Columns\TextColumn::make('bank_account_name')
                    ->searchable(),
            ])
            ->filters([
                
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListUserFinances::route('/'),
            'create' => Pages\CreateUserFinance::route('/create'),
            'edit' => Pages\EditUserFinance::route('/{record}/edit'),
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

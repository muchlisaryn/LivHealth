<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationGroup = 'Admin';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('programs_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('total_price')
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
                Tables\Columns\TextColumn::make('id')
                    ->label('No Transaksi')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Customer')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_price')
                    ->label('Total Harga')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')->badge()->color(fn(string $state) : string => match($state) {
                    'Pending' => 'gray',
                    'Confirmed' => 'success',
                    'Cooking' => 'info',
                    'Delivered' => 'warning',
                    'Canceled' => 'danger',
                    'Payment Rejected' => 'danger'
                    })
                    ->alignCenter()
                    ->label('Status Pemesanan'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu')
                    ->dateTime()
                    ->sortable(),
                 
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                ->options([
                    'Pending' => 'Pending',
                    'Canceled' => 'Canceled',
                    'Preparing' => 'Preparing'
                ])
            ])
            ->actions([
                // Action::make('View')
                // ->button()
                // ->color('info')
                // ->requiresConfirmation()
                // ->action(function(Transaction $transaction) {
                //     Transaction::find($transaction->id)->update([
                //         'status' => 'Canceled'
                //     ]);
                //     Notification::make()->success('Transaction Approved!')->body('Transaction has been approved successfully')->icon('heroicon-o-check')->send();
                // })
                // ->hidden(fn(Transaction $transaction) => $transaction->status === 'Canceled'),
               
                Action::make('reject')
                ->button()
                ->color('danger')
                ->requiresConfirmation()
                ->action(function(Transaction $transaction) {
                    Transaction::find($transaction->id)->update([
                        'status' => 'Canceled'
                    ]);
                    Notification::make()->success('Transaction Approved!')->body('Transaction has been approved successfully')->icon('heroicon-o-check')->send();
                })
                ->hidden(fn(Transaction $transaction) => $transaction->status != 'Pending' ),
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
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
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

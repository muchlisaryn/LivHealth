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
                Tables\Columns\TextColumn::make('sub_total')
                    ->label('Total Harga')
                    ->numeric()
                    ->sortable()
                    ->prefix('Rp'),
                Tables\Columns\TextColumn::make('status')->badge()->color(fn(string $state) : string => match($state) {
                    'Pending' => 'gray',
                    'Confirmed' => 'success',
                    'Verified Payment' => 'success',
                    'Order Completely Cooked' => 'success',
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
                Action::make('Confirmed')
                ->button()
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('Transaction')
                ->modalContent(function(Transaction $transaction) {
                    return view('components.confirmed-order' , [
                        'status_payment' => $transaction->payment->status_payment,
                        'programs_duration' => $transaction->programs->duration_days,
                        'programs_name' => $transaction->programs->name,
                        'order_total' => $transaction->order_price,
                        'shipping_price' => $transaction->shipping_price,
                        'sub_total' => $transaction->sub_total
                    ]);
                })
                ->action(function(Transaction $transaction) {
                    Transaction::find($transaction->id)->update([
                        'status' => 'Confirmed',
                    ]);
                    Notification::make()->success('Transaction Approved!')->body('Payment has been approved successfully')->icon('heroicon-o-check')->send();
                })
                ->hidden(fn(Transaction $transaction) => $transaction->status != 'Pending' ),
                
                Action::make('Reactivate')
                ->button()
                ->color('success')
                ->requiresConfirmation()
                ->action(function(Transaction $transaction) {
                    Transaction::find($transaction->id)->update([
                        'status' => 'Pending',
                        'canceled_reason' => null
                    ]);
                    Notification::make()->success('Order Reactivated Successfully!')->body('Order Reactivated Successfully!')->icon('heroicon-o-x-circle')->send();
                })
                ->hidden(fn(Transaction $transaction) => $transaction->status != 'Canceled' ),

                Action::make('Reason')
                ->button()
                ->color('info')
                ->requiresConfirmation()
                ->modalHeading('Cancellation Reason')
                ->modalSubheading('the reason for cancellation of this transaction.')
                ->modalContent(function(Transaction $transaction) {
                    return view('components.cancellation-reason' , [
                        'reason' => $transaction->canceled_reason ?? 'No reason provided'
                    ]);
                })
                ->form(null)
                ->modalSubmitAction(false)
                ->hidden(fn(Transaction $transaction) => $transaction->status != 'Canceled'),

                Action::make('reject')
                ->button()
                ->color('danger')
                ->requiresConfirmation()
                ->form([
                    Forms\Components\Textarea::make('canceled_reason')
                    ->label('Reason for Cancellation')
                    ->required()
                    ->placeholder('Provide the reason for canceling this transaction.'),
                ])
                ->action(function(Transaction $transaction, array $data) {
                    Transaction::find($transaction->id)->update([
                        'status' => 'Canceled',
                        'canceled_reason' => $data['canceled_reason']
                    ]);
                    Notification::make()->success('Transaction Canceled!')->body('Transaction has been canceled successfully')->icon('heroicon-o-x-circle')->send();
                })
                ->hidden(fn(Transaction $transaction) => $transaction->status != 'Pending' ),

                Action::make('Reason')
                ->button()
                ->color('info')
                ->requiresConfirmation()
                ->modalHeading('Cancellation Reason')
                ->modalSubheading('the reason for cancellation of this transaction.')
                ->modalContent(function(Transaction $transaction) {
                    return view('components.cancellation-reason' , [
                        'reason' => $transaction->canceled_reason ?? 'No reason provided'
                    ]);
                })
                ->form(null)
                ->modalSubmitAction(false)
                ->hidden(fn(Transaction $transaction) => $transaction->status != 'Payment Rejected'),
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
            'index' => Pages\ListTransactions::route('/'),
            // 'create' => Pages\CreateTransaction::route('/create'),
            // 'edit' => Pages\EditTransaction::route('/{record}/edit'),
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

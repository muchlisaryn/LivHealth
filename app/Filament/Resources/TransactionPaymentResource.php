<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionPaymentResource\Pages;
use App\Models\OrderCooking;
use App\Models\Transaction;
use App\Models\TransactionPayment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Log;

class TransactionPaymentResource extends Resource
{
    protected static ?string $model = TransactionPayment::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationGroup = 'Finance';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('transaction_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('status_payment')
                    ->required(),
                Forms\Components\Textarea::make('attachments')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('transaction_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('transaction.user.name')
                ->label('Customer'),
                Tables\Columns\TextColumn::make('transaction.total_price')
                ->label('Total Payment'),
                Tables\Columns\TextColumn::make('status_payment')
                ->badge()->color(fn(string $state) : string => match($state) {
                    'Pending' => 'gray',
                    'Verified' => 'success',
                    'Paid' => 'info',
                    'Rejected' => 'danger'
                })
                ->alignCenter(),
            ])
            ->filters([
               
            ])
            ->actions([
                Action::make('Confirmed')
                ->button()
                ->color('success')
                ->requiresConfirmation()
                ->action(function(TransactionPayment $payment) {

                    $transaction = $payment->transaction;

                    if($transaction) {
                        $transaction->update([
                            'status' => 'Confirmed'
                        ]);
                        
                        $payment->update([
                            'status_payment' => 'Verified'
                        ]);

                        OrderCooking::create([
                            'transaction_id' => $transaction->id,
                        ]);
                    }
                    
                    Notification::make()->success('Transaction Approved!')->body('Payment has been approved successfully')->icon('heroicon-o-check')->send();
                })
                ->hidden(fn(TransactionPayment $payment) => $payment->status_payment != 'Paid'),

                Action::make('Reject')
                ->button()
                ->color('danger')
                ->requiresConfirmation()
                ->action(function(TransactionPayment $payment) {

                    $transaction = $payment->transaction;

                    if($transaction) {
                        $transaction->update([
                            'status' => 'Payment Rejected'
                        ]);
                        
                        $updatedPayment = $payment->update([
                            'status_payment' => 'Rejected'
                        ]);

                        if($updatedPayment){
                            Log::error('Failed to update payment status', ['payment_id' => $payment->id]);
                        }
                    }

                    Notification::make()->success('Transaction Approved!')->body('Payment has been rejected')->icon('heroicon-o-check')->send();
                })
                ->hidden(fn(TransactionPayment $payment) => $payment->status_payment != 'Paid'),
                
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
            'index' => Pages\ListTransactionPayments::route('/'),
            'create' => Pages\CreateTransactionPayment::route('/create'),
            'edit' => Pages\EditTransactionPayment::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ])
            ->whereHas('transaction', function(Builder $query) {
                $query->where('status' , '!=' , 'Cancelled');
            });
    }
}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionPaymentResource\Pages;
use App\Models\OrderCooking;
use App\Models\ProgramPlans;
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
                    ->prefix('#')
                    ->sortable(),
                Tables\Columns\TextColumn::make('transaction.user.name')
                ->label('Customer'),
                Tables\Columns\TextColumn::make('created_at')
                ->label('Waktu Pembayaran'),
                Tables\Columns\TextColumn::make('transaction.sub_total')
                ->label('Total Harga')
                ->numeric()
                ->sortable()
                ->prefix('Rp '),
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
                Action::make('Reason')
                ->button()
                ->color('info')
                ->requiresConfirmation()
                ->modalHeading('Reject Reason')
                ->modalSubheading('the reason for cancellation of this transaction.')
                ->modalContent(function(TransactionPayment $payment) {
                    return view('components.cancellation-reason' , [
                        'reason' => $payment->transaction->canceled_reason ?? 'No reason provided'
                    ]);
                })
                ->form(null)
                ->modalSubmitAction(false)
                ->hidden(fn(TransactionPayment $payment) => $payment->transaction->status != 'Payment Rejected'),

                Action::make('Confirmed')
                ->button()
                ->color('success')
                // ->requiresConfirmation()
                ->modalHeading('Confirmation Payment')
                ->modalContent(function(TransactionPayment $payment){
                    return view('components.confirmed-payment', [
                        'status_payment' => $payment->status_payment,
                        'date_payment' => $payment->created_at,
                        'programs_duration' => $payment->transaction->programs->duration_days,
                        'programs_name' => $payment->transaction->programs->name,
                        'order_total' => $payment->transaction->order_price,
                        'shipping_price' => $payment->transaction->shipping_price,
                        'sub_total' => $payment->transaction->sub_total
                    ]);
                })
                ->modalSubmitAction(false)
                
                ->extraModalFooterActions([
                    Action::make('Approved')
                    ->button()
                    ->color('success')
                    ->requiresConfirmation()
                    
                    ->action(function(TransactionPayment $payment) {

                        $transaction = $payment->transaction;
    
                        if($transaction) {
                            $transaction->update([
                                'status' => 'Verified Payment'
                            ]);
                            
                            $payment->update([
                                'status_payment' => 'Verified'
                            ]);
    
                            ProgramPlans::create([
                                'transaction_id' => $transaction->id,
                            ]);
                        }
                        
                        Notification::make()->success('Transaction Approved!')->body('Payment has been approved successfully')->icon('heroicon-o-check')->send();
                    }),

                    Action::make('Reject')
                    ->button()
                    ->color('danger')
                    ->requiresConfirmation()
                    ->form([
                        Forms\Components\Textarea::make('canceled_reason')
                        ->label('Reason for Cancellation')
                        ->required()
                        ->placeholder('Provide the reason for canceling this transaction.'),
                    ])
                    ->action(function(TransactionPayment $payment, array $data) {

                        $transaction = $payment->transaction;

                        if($transaction) {
                            $transaction->update([
                                'status' => 'Payment Rejected',
                                'canceled_reason' => $data['canceled_reason']
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
                ])
                ->modalWidth('lg') // Optional: Adjust modal width
                
                ->hidden(fn(TransactionPayment $payment) => $payment->status_payment != 'Paid'),

                
                
                
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
            'index' => Pages\ListTransactionPayments::route('/'),
            // 'create' => Pages\CreateTransactionPayment::route('/create'),
            // 'edit' => Pages\EditTransactionPayment::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ])
            ->whereHas('transaction', function(Builder $query) {
                $query->whereIn('status', ['Confirmed', 'Payment Rejected', 'Verified Payment']);
            });
    }
}

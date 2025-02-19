<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderDeliveryResource\Pages;
use App\Filament\Resources\OrderDeliveryResource\RelationManagers;
use App\Models\Order;
use App\Models\OrderDelivery;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class OrderDeliveryResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationGroup = 'Kurir';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

       public static function canAccess(): bool
    {
        return Auth::check() && Auth::user()->role === 'kurir';
    }

    public static function canView(Model $record): bool
    {
        return Auth::user()->role === 'kurir';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(fn (Order $order) => $order
            ->whereNotIn('status', ['Pending'])
            )
            ->columns([
                Tables\Columns\TextColumn::make('transaction.user.name')
                    ->label('Customer'),
                Tables\Columns\TextColumn::make('transaction.user.address')
                    ->label('Alamat'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()->color(fn(string $state) : string => match($state) {
                        'Pending' => 'info',
                        'On The Way' => 'gray',
                        'Completed' => 'success',
                    })
            ])
            ->filters([
                //
            ])

            ->actions([
               Action::make('Completed')
                ->button()
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('Process Delivery')
                ->action(function(Order $order) {
                   try {
                        $order->update([
                            'status' => 'Completed',
                        ]);

                        Notification::make()->success('Order Completed')->body('The order has been completed and successfully delivered to the customer.')->icon('heroicon-o-check')->send();
                 
                   } catch (\Exception $e) {
                    Notification::make()->danger()->body('Error: ' . $e->getMessage())->send();
                   }
                })
                ->hidden(fn(Order $order) => $order->status != 'On The Way'),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListOrderDeliveries::route('/'),
            // 'create' => Pages\CreateOrderDelivery::route('/create'),
            // 'edit' => Pages\EditOrderDelivery::route('/{record}/edit'),
        ];
    }
}

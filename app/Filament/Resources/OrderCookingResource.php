<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderCookingResource\Pages;
use App\Filament\Resources\OrderCookingResource\RelationManagers;
use App\Models\Menus;
use App\Models\OrderCooking;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
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
                Tables\Columns\TextColumn::make('user_program.transaction.id')
                    ->label('No Transaksi')
                    ->prefix('#')
                    ->numeric()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu Order')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user_program.transaction.user.name')
                    ->searchable()
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
                Action::make('Process')
                ->button()
                ->color('info')
                ->requiresConfirmation()
                ->modalHeading('Process Order')
                ->modalContent(function(OrderCooking $order) {

                    $orders = [];

                    foreach($order->menu_id as $menu){
                        $menu_order = Menus::find($menu);
                        if($menu_order) {
                            $orders[] = $menu_order->name;
                        }
                    }

                    return view('components.confirmed-order-cooking' , [
                        'no_transaksi' => $order->user_program->transaction->id,
                        'nama_customer' => $order->user_program->transaction->user->name,
                        'orders' => $orders
                    ]);
                })
                ->action(function(OrderCooking $cooking) {
                   try {
                    $transaction = $cooking->user_program->transaction;

                    if($transaction){
                        $update_transaction = $transaction->update([
                            'status' => 'Cooking'
                        ]);

                        if(!$update_transaction){
                            Notification::make()->success('Error!')->body('Tidak dapat mengupdate transaksi')->icon('heroicon-o-check')->send();
                        }

                        $update_cooking_status = $cooking->update([
                            'status' => 'In Progress',
                        ]);

                        if(!$update_cooking_status) {
                            Notification::make()->success('Error!')->body('Gagal Update Pemesanan')->icon('heroicon-o-check')->send();
                        }

                        Notification::make()->success('order Processed!')->body('The order has been processed successfully.')->icon('heroicon-o-check')->send();
                    }else {
                        Notification::make()->success('Error!')->body('Transaksi Tidak Ditemukan')->icon('heroicon-o-check')->send();
                    }
                   } catch (\Exception $e) {
                    Notification::make()->danger()->body('Error: ' . $e->getMessage())->send();
                   }
                })
                ->hidden(fn(OrderCooking $cooking) => $cooking->status != 'New'),

                Action::make('Completed')
                ->button()
                ->color('success')
                ->requiresConfirmation()
                ->modalContent(function(OrderCooking $order) {

                    $orders = [];

                    foreach($order->menu_id as $menu){
                        $menu_order = Menus::find($menu);
                        if($menu_order) {
                            $orders[] = $menu_order->name;
                        }
                    }

                    return view('components.confirmed-order-cooking' , [
                        'no_transaksi' => $order->user_program->transaction->id,
                        'nama_customer' => $order->user_program->transaction->user->name,
                        'orders' => $orders
                    ]);
                })
                ->action(function(OrderCooking $cooking) {
                    $cooking->update([
                        'status' => 'Ready for Pickup',
                    ]);

                    Notification::make()->success('order Processed!')->body('The order has been processed successfully.')->icon('heroicon-o-check')->send();
                })
                ->hidden(fn(OrderCooking $cooking) => $cooking->status != 'In Progress')
            ])
            ->bulkActions([
               
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

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderCookingResource\Pages;
use App\Filament\Resources\OrderCookingResource\RelationManagers;
use App\Models\Menus;
use App\Models\Order;
use App\Models\OrderCooking;
use App\Models\WeeklySchedule;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class OrderCookingResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Admin';
    
    protected static ?string $navigationLabel = 'Oder List';

    public static function canAccess(): bool
    {
        return Auth::check() && Auth::user()->role === 'admin';
    }

    public static function canView(Model $record): bool
    {
        return Auth::user()->role === 'admin';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('transaction.id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('status')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(fn (Order $order) => $order
            ->where('date', Carbon::today())
            ->whereNotIn('status', ['Completed'])
            )
            ->columns([
                Tables\Columns\TextColumn::make('transaction.id')
                    ->label('No Transaksi')
                    ->prefix('#')
                    ->numeric()
                    ->searchable(),
                Tables\Columns\TextColumn::make('transaction.user.name')
                    ->searchable()
                    ->label('Customer'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()->color(fn(string $state) : string => match($state) {
                        'New' => 'info',
                        'On The Way' => 'gray',
                        'Completed' => 'success',
                    })
            ])
            ->filters([
                // Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Action::make('Confirm')
                ->button()
                ->color('info')
                ->requiresConfirmation()
                ->modalHeading('Process Order')
                ->modalContent(function(Order $order) {

                    $menuIds = WeeklySchedule::where('category_id', $order->category_id)
                    ->pluck('menu_id')
                    ->flatten()
                    ->unique();

                    $menus = Menus::whereIn('id', $menuIds)
                    ->pluck('name')
                    ->toArray();

                    return view('components.confirmed-order-cooking' , [
                        'no_transaksi' => $order->transaction->id,
                        'nama_customer' => $order->transaction->user->name,
                        'orders' => $menus
                    ]);
                })
                ->action(function(Order $order) {
                   try {
                        $order->update([
                            'status' => 'On The Way',
                        ]);

                        Notification::make()->success('order Processed!')->body('The order has been processed successfully.')->icon('heroicon-o-check')->send();
                 
                   } catch (\Exception $e) {
                    Notification::make()->danger()->body('Error: ' . $e->getMessage())->send();
                   }
                })
                ->hidden(fn(Order $order) => $order->status != 'New'),
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

<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class SalesReport extends ChartWidget
{
    protected static ?string $heading = 'Penjualan Harian';

    protected function getData(): array
    {   
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        $salesPerDay = [];

        for($i = 0; $i < 7; $i++){
            $day = $startOfWeek->copy()->addDays($i);
            $dailySales = Transaction::whereDate('created_at', $day)
                          ->where('status', 'Verified Payment')
                          ->sum('sub_total');
            $salesPerDay[] = $dailySales;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Penjualan Harian',
                    'data' => $salesPerDay,
                    'backgroundColor' => '#ff6384',
                ],
               
            ],
            'labels' => ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
            
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}

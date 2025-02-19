<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class SalesReportPerMonth extends ChartWidget
{
    protected static ?string $heading = 'Penjualan Perbulan';

    protected function getData(): array
    {
        $currentMonth = Carbon::now();
        $months = [];

        // Array untuk menampung total penjualan per bulan
        $salesPerMonth = [];

        // Loop untuk mendapatkan total penjualan per bulan selama 6 bulan terakhir
        for ($i = 0; $i < 6; $i++) {
            // Tentukan bulan (6 bulan terakhir)
            $monthStart = $currentMonth->copy()->subMonths($i)->startOfMonth(); // Awal bulan
            $monthEnd = $currentMonth->copy()->subMonths($i)->endOfMonth(); // Akhir bulan

            // Hitung total penjualan untuk bulan ini (filter berdasarkan status pembayaran)
            $monthlySales = Transaction::whereBetween('created_at', [$monthStart, $monthEnd])
                ->where('status', 'Verified Payment')
                ->sum('sub_total');

            // Masukkan total penjualan per bulan ke dalam array
            $salesPerMonth[] = $monthlySales;

            // Simpan label bulan untuk grafik
            $months[] = $monthStart->format('F Y'); // Format nama bulan (contoh: Januari 2025)
        }

        return [
            'datasets' => [
                [
                    'label' => 'Penjualan Bulanan',
                    'data' => array_reverse($salesPerMonth), // Data penjualan per bulan
                    'backgroundColor' => '#ffce56', // Warna grafik
                ],
            ],
            'labels' => array_reverse($months), // Label untuk nama bulan (6 bulan terakhir)
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}

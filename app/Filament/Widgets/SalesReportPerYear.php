<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class SalesReportPerYear extends ChartWidget
{
    protected static ?string $heading = 'Penjualan Pertahun';

    protected function getData(): array
    {
        $currentYear = Carbon::now()->year;
        $years = [];
        $salesPerYear = [];

        // Loop untuk mendapatkan total penjualan per tahun selama 6 tahun (tahun ini + 5 tahun sebelumnya)
        for ($i = 0; $i < 6; $i++) {
            // Tentukan tahun (5 tahun sebelumnya + tahun ini)
            $year = $currentYear - $i;

            // Hitung total penjualan untuk tahun ini
            $yearStart = Carbon::createFromDate($year, 1, 1)->startOfYear(); // Awal tahun
            $yearEnd = Carbon::createFromDate($year, 12, 31)->endOfYear(); // Akhir tahun

            // Hitung total penjualan selama tahun tersebut (filter berdasarkan status pembayaran)
            $yearlySales = Transaction::whereBetween('created_at', [$yearStart, $yearEnd])
                ->where('status', 'Verified Payment')
                ->sum('sub_total');

            // Masukkan total penjualan per tahun ke dalam array
            $salesPerYear[] = $yearlySales;

            // Simpan label tahun untuk grafik
            $years[] = $year; // Format nama tahun
        }

        // Balikkan urutan tahun, supaya tahun ini ada di depan
        $years = array_reverse($years);
        $salesPerYear = array_reverse($salesPerYear);

        return [
            'datasets' => [
                [
                    'label' => 'Penjualan Tahunan',
                    'data' => $salesPerYear, // Data penjualan per tahun
                    'backgroundColor' => '#36a2eb', // Warna grafik
                ],
            ],
            'labels' => $years, // Label untuk nama tahun (6 tahun terakhir, dengan tahun ini di depan)
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}

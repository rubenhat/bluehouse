<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // Set default date range (last 7 days)
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->subDays(6);
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now();

        // Ensure end date includes the full day
        $endDate = $endDate->endOfDay();

        // Get transactions within date range
        $transactions = Order::whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Calculate statistics
        $totalPendapatan = Order::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', '!=', 'cancelled')
            ->sum('total_amount');

        $totalPesanan = Order::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', '!=', 'cancelled')
            ->count();

        $pesananDibatalkan = Order::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'cancelled')
            ->count();

        $rataRataNilaiPesanan = $totalPesanan > 0 ? $totalPendapatan / $totalPesanan : 0;

        // Chart data for the last 7 days
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $revenue = Order::whereDate('created_at', $date)
                ->where('status', '!=', 'cancelled')
                ->sum('total_amount');

            $chartData[] = [
                'date' => $date->format('d M'),
                'revenue' => $revenue
            ];
        }

        return view('admin.laporan', compact(
            'transactions',
            'totalPendapatan',
            'totalPesanan',
            'pesananDibatalkan',
            'rataRataNilaiPesanan',
            'chartData',
            'startDate',
            'endDate'
        ));
    }

    public function exportPDF(Request $request)
    {
        // Set default date range if not provided
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->subDays(6);
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now();

        // Ensure end date includes the full day
        $endDate = $endDate->endOfDay();

        // Get all transactions within date range (without pagination for PDF)
        $transactions = Order::whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'desc')
            ->get();

        // Calculate statistics
        $totalPendapatan = Order::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', '!=', 'cancelled')
            ->sum('total_amount');

        $totalPesanan = Order::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', '!=', 'cancelled')
            ->count();

        $pesananDibatalkan = Order::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'cancelled')
            ->count();

        $rataRataNilaiPesanan = $totalPesanan > 0 ? $totalPendapatan / $totalPesanan : 0;

        // Generate PDF
        $pdf = Pdf::loadView('admin.export.laporan-pdf', compact(
            'transactions',
            'totalPendapatan',
            'totalPesanan',
            'pesananDibatalkan',
            'rataRataNilaiPesanan',
            'startDate',
            'endDate'
        ));

        // Set paper size and orientation
        $pdf->setPaper('A4', 'landscape');

        // Generate filename with date range
        $filename = 'laporan-transaksi-' . $startDate->format('Y-m-d') . '-sampai-' . $endDate->format('Y-m-d') . '.pdf';

        // Download the PDF
        return $pdf->download($filename);
    }
}

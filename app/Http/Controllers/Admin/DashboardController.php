<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\DownloadHistory;
use App\Models\Template;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman dashboard utama.
     */
    public function index()
    {
        $jumlah_sertifikat = Certificate::count();
        $jumlah_download = DownloadHistory::count();
        $jumlah_template = Template::count();
        $jumlah_hari_ini = DownloadHistory::whereDate('created_at', Carbon::today())->count();

        // Recent activity: gabungan download histories terbaru, paginated at 4 items
        $recent_activities = DownloadHistory::with('certificate')
            ->latest()
            ->paginate(4, ['*'], 'activities_page');

        // Data Grafik download 7 hari terakhir
        $chart_data = [];
        $chart_labels = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $chart_labels[] = $date->translatedFormat('d M');
            $chart_data[] = DownloadHistory::whereDate('created_at', $date)->count();
        }

        return view('admin.dashboard', compact(
            'jumlah_sertifikat',
            'jumlah_download',
            'jumlah_template',
            'jumlah_hari_ini',
            'recent_activities',
            'chart_labels',
            'chart_data'
        ));
    }

    /**
     * Tampilkan riwayat unduhan sertifikat.
     */
    public function downloadHistories()
    {
        $histories = DownloadHistory::with('certificate')
            ->latest()
            ->paginate(10); // Standard pagination with 10 items per page

        return view('admin.download-histories', compact('histories'));
    }
}

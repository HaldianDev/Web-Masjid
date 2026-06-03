<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Article;
use App\Models\Finance;
use App\Models\Setting;
use App\Models\ZisRecord;
use App\Services\PrayerTimeService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LandingPageController extends Controller
{
    protected PrayerTimeService $prayerTimeService;

    public function __construct(PrayerTimeService $prayerTimeService)
    {
        $this->prayerTimeService = $prayerTimeService;
    }

    public function index()
    {
        // Fetch Profile Settings
        $profile = [
            'name' => Setting::getValue('masjid_name', "As-Sa'adah Desa Belambangan"),
            'address' => Setting::getValue('masjid_address', 'Bandung'),
            'history' => Setting::getValue('masjid_history'),
            'vision' => Setting::getValue('masjid_vision'),
            'mission' => Setting::getValue('masjid_mission'),
            'facilities' => Setting::getValue('masjid_facilities'),
            'legalities' => Setting::getValue('masjid_legalities'),
            'structure' => Setting::getValue('masjid_structure'),
        ];

        // 7. Fetch Qurban stats for Eid al-Adha 2026 / 1447 H
        $qurbanStats = [
            'sapi' => \App\Models\Qurban::where('year', '1447 H / 2026')->where('type', 'sapi')->count(),
            'kambing' => \App\Models\Qurban::where('year', '1447 H / 2026')->where('type', 'kambing')->count(),
            'participants' => \App\Models\Qurban::where('year', '1447 H / 2026')->orderBy('created_at', 'desc')->take(10)->get()
        ];

        return view('welcome', compact(
            'profile', 'qurbanStats'
        ));
    }

    public function showArticle(string $slug)
    {
        $article = Article::where('slug', $slug)->firstOrFail();
        return view('public.article-detail', compact('article'));
    }

    public function showPrayerSchedule()
    {
        $prayerTimes = $this->prayerTimeService->getTimings();
        $nextFridaySchedule = \App\Models\FridaySchedule::where('date', '>=', now()->toDateString())
            ->orderBy('date', 'asc')
            ->first();

        return view('public.prayer-schedule', compact('prayerTimes', 'nextFridaySchedule'));
    }

    public function showActivities()
    {
        $activities = Activity::where('event_date', '>=', now()->toDateString())
            ->orderBy('event_date', 'asc')
            ->get(); // Get all activities, not just 5

        return view('public.activities', compact('activities'));
    }

    public function showProfile()
    {
        $profile = [
            'name' => Setting::getValue('masjid_name', "As-Sa'adah Desa Belambangan"),
            'address' => Setting::getValue('masjid_address', 'Bandung'),
            'history' => Setting::getValue('masjid_history'),
            'vision' => Setting::getValue('masjid_vision'),
            'mission' => Setting::getValue('masjid_mission'),
            'facilities' => Setting::getValue('masjid_facilities'),
            'legalities' => Setting::getValue('masjid_legalities'),
            'structure' => Setting::getValue('masjid_structure'),
        ];

        return view('public.profile', compact('profile'));
    }

    public function showFinanceTransparency()
    {
        $totalIn = Finance::where('type', 'in')->sum('amount');
        $totalOut = Finance::where('type', 'out')->sum('amount');
        $balance = $totalIn - $totalOut;

        $recentTransactions = Finance::orderBy('transaction_date', 'desc')
            ->orderBy('id', 'desc')
            ->take(5)
            ->get();

        $driver = \Illuminate\Support\Facades\DB::connection()->getDriverName();
        if ($driver === 'sqlite') {
            $weeklyFinances = Finance::selectRaw("
                strftime('%Y', transaction_date) as year,
                strftime('%W', transaction_date) as week,
                SUM(CASE WHEN type = 'in' THEN amount ELSE 0 END) as total_in,
                SUM(CASE WHEN type = 'out' THEN amount ELSE 0 END) as total_out
            ")
            ->groupBy('year', 'week')
            ->orderBy('year', 'desc')
            ->orderBy('week', 'desc')
            ->take(5)
            ->get();

            $monthlyFinances = Finance::selectRaw("
                strftime('%Y', transaction_date) as year,
                strftime('%m', transaction_date) as month,
                SUM(CASE WHEN type = 'in' THEN amount ELSE 0 END) as total_in,
                SUM(CASE WHEN type = 'out' THEN amount ELSE 0 END) as total_out
            ")
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->take(5)
            ->get();
        } else {
            $weeklyFinances = Finance::selectRaw("
                YEAR(transaction_date) as year,
                WEEK(transaction_date, 1) as week,
                SUM(CASE WHEN type = 'in' THEN amount ELSE 0 END) as total_in,
                SUM(CASE WHEN type = 'out' THEN amount ELSE 0 END) as total_out
            ")
            ->groupBy('year', 'week')
            ->orderBy('year', 'desc')
            ->orderBy('week', 'desc')
            ->take(5)
            ->get();

            $monthlyFinances = Finance::selectRaw("
                YEAR(transaction_date) as year,
                MONTH(transaction_date) as month,
                SUM(CASE WHEN type = 'in' THEN amount ELSE 0 END) as total_in,
                SUM(CASE WHEN type = 'out' THEN amount ELSE 0 END) as total_out
            ")
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->take(5)
            ->get();
        }

        $zisStats = [
            'total_muzakki_money' => ZisRecord::where('person_type', 'muzakki')->whereNotNull('amount_money')->sum('amount_money'),
            'total_muzakki_rice' => ZisRecord::where('person_type', 'muzakki')->whereNotNull('amount_rice')->sum('amount_rice'),
            'total_mustahik_money' => ZisRecord::where('person_type', 'mustahik')->whereNotNull('amount_money')->sum('amount_money'),
            'total_mustahik_rice' => ZisRecord::where('person_type', 'mustahik')->whereNotNull('amount_rice')->sum('amount_rice'),
            'count_muzakki' => ZisRecord::where('person_type', 'muzakki')->count(),
            'count_mustahik' => ZisRecord::where('person_type', 'mustahik')->count(),
        ];

        return view('public.finance-transparency', compact(
            'totalIn', 'totalOut', 'balance', 'recentTransactions', 
            'weeklyFinances', 'monthlyFinances', 'zisStats'
        ));
    }

    public function showArticlesList()
    {
        $articles = Article::orderBy('published_at', 'desc')
            ->get(); // Get all articles

        return view('public.articles-list', compact('articles'));
    }

    public function showQurban()
    {
        $qurbanStats = [
            'sapi' => \App\Models\Qurban::where('year', '1447 H / 2026')->where('type', 'sapi')->count(),
            'kambing' => \App\Models\Qurban::where('year', '1447 H / 2026')->where('type', 'kambing')->count(),
            'participants' => \App\Models\Qurban::where('year', '1447 H / 2026')->orderBy('created_at', 'desc')->get() // Get all participants for the dedicated page
        ];

        return view('public.qurban', compact('qurbanStats'));
    }
}

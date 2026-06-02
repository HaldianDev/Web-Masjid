<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Article;
use App\Models\Finance;
use App\Models\Inventory;
use App\Models\ZisRecord;
use App\Models\Donation;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Totals
        $totalIn = Finance::where('type', 'in')->sum('amount');
        $totalOut = Finance::where('type', 'out')->sum('amount');
        $balance = $totalIn - $totalOut;

        $activityCount = Activity::count();
        $inventoryCount = Inventory::sum('quantity');
        $articleCount = Article::count();
        $userCount = User::count();

        // New Friday Schedules & Qurban metrics
        $fridayScheduleCount = \App\Models\FridaySchedule::count();
        $qurbanParticipantCount = \App\Models\Qurban::count();
        $qurbanSapiCount = \App\Models\Qurban::where('type', 'sapi')->count();
        $qurbanKambingCount = \App\Models\Qurban::where('type', 'kambing')->count();

        // Donations overview
        $totalDonationSuccess = Donation::where('status', 'success')->sum('amount');
        $pendingDonationsCount = Donation::where('status', 'pending')->count();

        // ZIS Summary
        $zisMuzakkiMoney = ZisRecord::where('person_type', 'muzakki')->whereNotNull('amount_money')->sum('amount_money');
        $zisMuzakkiRice = ZisRecord::where('person_type', 'muzakki')->whereNotNull('amount_rice')->sum('amount_rice');
        $zisMustahikMoney = ZisRecord::where('person_type', 'mustahik')->whereNotNull('amount_money')->sum('amount_money');
        $zisMustahikRice = ZisRecord::where('person_type', 'mustahik')->whereNotNull('amount_rice')->sum('amount_rice');

        // Recent content and items
        $recentActivities = Activity::orderBy('event_date', 'asc')->take(5)->get();
        $recentTransactions = Finance::orderBy('transaction_date', 'desc')->take(5)->get();

        return view('dashboard', compact(
            'totalIn', 'totalOut', 'balance',
            'activityCount', 'inventoryCount', 'articleCount', 'userCount',
            'totalDonationSuccess', 'pendingDonationsCount',
            'zisMuzakkiMoney', 'zisMuzakkiRice', 'zisMustahikMoney', 'zisMustahikRice',
            'recentActivities', 'recentTransactions',
            'fridayScheduleCount', 'qurbanParticipantCount', 'qurbanSapiCount', 'qurbanKambingCount'
        ));
    }
}

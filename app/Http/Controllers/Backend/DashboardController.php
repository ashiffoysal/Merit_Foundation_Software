<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Subscription;
use Carbon\Carbon;
use App\Models\BookLesson;

class DashboardController extends Controller
{
    // Dashboard view
 public function index()
    {
        $now              = Carbon::now();
        $startOfMonth      = $now->copy()->startOfMonth();
        $startOfLastMonth  = $now->copy()->subMonth()->startOfMonth();
        $endOfLastMonth    = $now->copy()->subMonth()->endOfMonth();
 
        // ---------------- Students (users table) ----------------
        $activeStudents        = User::where('is_active', 1)->count();
        $newStudentsThisMonth  = User::where('is_active', 1)
            ->where('created_at', '>=', $startOfMonth)
            ->count();
 
        // ---------------- Donations / revenue (transactions table) ----------------
        $donationsThisMonth = Transaction::where('status', 'paid')
            ->whereBetween('created_at', [$startOfMonth, $now])
            ->sum('amount');
 
        $donationsLastMonth = Transaction::where('status', 'paid')
            ->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])
            ->sum('amount');
 
        $donationsChangePct = $donationsLastMonth > 0
            ? round((($donationsThisMonth - $donationsLastMonth) / $donationsLastMonth) * 100, 1)
            : null; // null = "no prior-month data to compare against"
 
        $totalDonationsThisYear = Transaction::where('status', 'paid')
            ->whereYear('created_at', $now->year)
            ->sum('amount');
 
        $totalDonorsCount = Transaction::where('status', 'paid')
            ->distinct('user_id')
            ->count('user_id');
 
        $monthlyDonorsCount = Transaction::where('status', 'paid')
            ->whereBetween('created_at', [$startOfMonth, $now])
            ->distinct('user_id')
            ->count('user_id');
 
        // ---------------- Subscriptions table ----------------
        $activeSubscriptions = Subscription::where('stripe_status', 'active')->count();
 
        // ---------------- 6-month revenue trend, for the bar chart ----------------
        $monthlyRevenue = collect(range(5, 0))->map(function ($i) use ($now) {
            $month = $now->copy()->subMonths($i);
            $sum = Transaction::where('status', 'paid')
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->sum('amount');
 
            return [
                'label' => $month->format('M'),
                'value' => (float) $sum,
            ];
        })->values();
 
        $maxMonthlyRevenue = $monthlyRevenue->max('value') ?: 1; // avoid divide-by-zero in the view
 
        // ---------------- Recent registrations (dashboard overview table) ----------------
        $recentUsers = User::latest()->take(5)->get();
 
        // ---------------- Activity feed: recent registrations + recent paid transactions ----------------
        $recentTransactions = Transaction::with('user')
            ->where('status', 'paid')
            ->latest()
            ->take(5)
            ->get();
 
        $activity = collect();
 
        foreach ($recentUsers as $u) {
            $activity->push([
                'icon_bg'  => 'var(--grnp)',
                'icon'     => 'fa-user-plus',
                'icon_col' => 'var(--grn)',
                'text'     => trim("{$u->name} {$u->last_name}") . ' registered',
                'time'     => $u->created_at,
            ]);
        }
 
        foreach ($recentTransactions as $t) {
            $donorName = $t->user ? trim("{$t->user->name} {$t->user->last_name}") : 'Unknown user';
            $activity->push([
                'icon_bg'  => 'var(--goldp)',
                'icon'     => 'fa-pound-sign',
                'icon_col' => 'var(--gold)',
                'text'     => '£' . number_format($t->amount, 2) . ' payment from ' . $donorName,
                'time'     => $t->created_at,
            ]);
        }
 
        $activity = $activity->sortByDesc('time')->take(6)->values();
 
        // ---------------- Students view table (users table only) ----------------
        // NOTE: "Tutor", "Progress", and "Next Lesson" columns have no
        // backing table/column, so they render as "N/A" in the view rather
        // than invented data. "Level" maps to users.quran_level.
        $students = User::orderByDesc('created_at')->paginate(10, ['*'], 'students_page');
 
        // ---------------- Donations view table (transactions + users) ----------------
        $donations = Transaction::with('user')
            ->orderByDesc('created_at')
            ->paginate(10, ['*'], 'donations_page');
 
        return view('backend.dashboard.index', compact(
            'activeStudents',
            'newStudentsThisMonth',
            'donationsThisMonth',
            'donationsChangePct',
            'totalDonationsThisYear',
            'totalDonorsCount',
            'monthlyDonorsCount',
            'activeSubscriptions',
            'monthlyRevenue',
            'maxMonthlyRevenue',
            'recentUsers',
            'activity',
            'students',
            'donations'
        ));
    }



    // All Leads view
    public function allLLeads()
    {
        $allleads = BookLesson::orderByDesc('created_at')->get();
        return view('backend.all_leads.index', compact('allleads'));
    }
 
}

<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Subscription;

use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class TransactionController extends Controller
{
    /**
     * Show the transactions page (view only — data is loaded via AJAX).
     */
    public function index()
    {
        return view('backend.transection.index');
    }
 
    /**
     * Server-side DataTables endpoint for transactions.
     *
     * transactions.user_id -> users.id                (explicit FK, direct join)
     * transactions -> subscriptions                    (no FK exists in the
     *   schema, so we join each transaction to the user's MOST RECENT
     *   subscription via a correlated subquery on user_id + MAX(created_at))
     */
    public function getData(Request $request)
    {
        // Subquery: latest subscription id per user.
        $latestSubIds = DB::table('subscriptions')
            ->select('user_id', DB::raw('MAX(id) as latest_id'))
            ->groupBy('user_id');
 
        $query = Transaction::query()
            ->select([
                'transactions.id',
                'transactions.user_id',
                'transactions.stripe_invoice_id',
                'transactions.amount',
                'transactions.currency',
                'transactions.status',
                'transactions.description',
                'transactions.created_at',
                'users.name as user_first_name',
                'users.last_name as user_last_name',
                'users.email as user_email',
                'users.pm_type',
                'users.pm_last_four',
                'subscriptions.stripe_price',
                'subscriptions.stripe_status as subscription_status',
            ])
            // Direct FK join: transactions.user_id -> users.id
            ->join('users', 'users.id', '=', 'transactions.user_id')
            // Correlated subquery join to find each user's latest subscription id
            ->leftJoinSub($latestSubIds, 'latest_sub', function ($join) {
                $join->on('latest_sub.user_id', '=', 'transactions.user_id');
            })
            // Join the actual subscription row using that latest id
            ->leftJoin('subscriptions', 'subscriptions.id', '=', 'latest_sub.latest_id');
 
        return DataTables::of($query)
            ->addColumn('user_full_name', function ($row) {
                return trim("{$row->user_first_name} {$row->user_last_name}");
            })
            ->addColumn('plan_name', function ($row) {
                return Subscription::planNameFromPrice($row->stripe_price);
            })
            ->editColumn('amount', function ($row) {
                return number_format((float) $row->amount, 2);
            })
            ->addColumn('status_badge', function ($row) {
                $map = Transaction::statusBadgeMap();
                $class = $map[strtolower($row->status)] ?? 'light';
                $label = ucfirst($row->status);
                return "<span class=\"badge bg-{$class}\">{$label}</span>";
            })
            ->addColumn('payment_method', function ($row) {
                if (!$row->pm_type) {
                    return 'N/A';
                }
                $type = strtoupper($row->pm_type);
                $last4 = $row->pm_last_four ? "•••• {$row->pm_last_four}" : '';
                return trim("{$type} {$last4}");
            })
            ->editColumn('created_at', function ($row) {
                return \Illuminate\Support\Carbon::parse($row->created_at)->format('M d, Y H:i');
            })
            // Allow DataTables global search to also match the joined columns
            ->filterColumn('user_full_name', function ($query, $keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->where('users.name', 'like', "%{$keyword}%")
                        ->orWhere('users.last_name', 'like', "%{$keyword}%");
                });
            })
            ->filterColumn('user_email', function ($query, $keyword) {
                $query->where('users.email', 'like', "%{$keyword}%");
            })
            ->rawColumns(['status_badge'])
            ->make(true);
    }
}

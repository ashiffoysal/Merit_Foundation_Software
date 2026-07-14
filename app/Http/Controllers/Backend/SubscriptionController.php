<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subscription;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SubscriptionController extends Controller
{

    public function index()
    {
        return view('backend.subscriptionuser.index');
    }

    public function getData(Request $request)
    {
        $query = Subscription::query()
            ->select([
                'subscriptions.id',
                'subscriptions.user_id',
                'subscriptions.type',
                'subscriptions.stripe_id',
                'subscriptions.stripe_status',
                'subscriptions.stripe_price',
                'subscriptions.quantity',
                'subscriptions.trial_ends_at',
                'subscriptions.ends_at',
                'subscriptions.created_at',
                'users.name as user_first_name',
                'users.last_name as user_last_name',
                'users.email as user_email',
            ])
            ->join('users', 'users.id', '=', 'subscriptions.user_id');
 
        return DataTables::of($query)
            ->addColumn('user_full_name', function ($row) {
                return trim("{$row->user_first_name} {$row->user_last_name}");
            })
            ->addColumn('plan_name', function ($row) {
                return Subscription::planNameFromPrice($row->stripe_price);
            })
            ->addColumn('status_badge', function ($row) {
                $map = [
                    'active'    => 'success',
                    'trialing'  => 'info',
                    'past_due'  => 'warning',
                    'canceled'  => 'secondary',
                    'unpaid'    => 'danger',
                    'incomplete' => 'warning',
                ];
                $status = strtolower($row->stripe_status);
                $class = $map[$status] ?? 'light';
                $label = ucfirst(str_replace('_', ' ', $row->stripe_status));
                return "<span class=\"badge bg-{$class}\">{$label}</span>";
            })
            ->editColumn('trial_ends_at', function ($row) {
                return $row->trial_ends_at
                    ? \Illuminate\Support\Carbon::parse($row->trial_ends_at)->format('M d, Y')
                    : '—';
            })
            ->editColumn('ends_at', function ($row) {
                // NOTE: schema has no dedicated "next billing date" column.
                // ends_at is the closest available field (used here as both
                // "End Date" and, where status is active, an implied next
                // renewal/expiry date).
                return $row->ends_at
                    ? \Illuminate\Support\Carbon::parse($row->ends_at)->format('M d, Y')
                    : '—';
            })
            ->editColumn('created_at', function ($row) {
                return \Illuminate\Support\Carbon::parse($row->created_at)->format('M d, Y H:i');
            })
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

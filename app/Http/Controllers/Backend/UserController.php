<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
// ── Main page ─────────────────────────────────────────────────────────────
    public function index()
    {
        return view('backend.user.index');
    }
 
    // ── AJAX data endpoint ────────────────────────────────────────────────────
    public function data(Request $request)
    {
        $query  = User::query();
        $search = $request->input('search', '');
        $status = $request->input('status', '');
 
        // Search
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name',       'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email',     'like', "%{$search}%")
                  ->orWhere('phone',     'like', "%{$search}%")
                  ->orWhere('country',   'like', "%{$search}%")
                  ->orWhere('student_name', 'like', "%{$search}%");
            });
        }
 
        // Filter by status
        match ($status) {
            'active'   => $query->where('is_active', 1)->where('is_deleted', 0),
            'inactive' => $query->where('is_active', 0),
            'verified' => $query->whereNotNull('email_verified_at'),
            'deleted'  => $query->where('is_deleted', 1),
            default    => null,
        };
 
        // Stats (before pagination)
        $stats = [
            'total'    => User::count(),
            'active'   => User::where('is_active', 1)->where('is_deleted', 0)->count(),
            'verified' => User::whereNotNull('email_verified_at')->count(),
            'deleted'  => User::where('is_deleted', 1)->count(),
        ];
 
        $paginated = $query->orderBy('created_at', 'desc')->paginate(10);
 
        return response()->json(array_merge(
            $paginated->toArray(),
            ['stats' => $stats]
        ));
    }
 
    // ── Single user (for modals) ──────────────────────────────────────────────
    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }
 
    // ── Toggle active/inactive ────────────────────────────────────────────────
    public function toggleActive($id)
    {
        $user = User::findOrFail($id);
        $user->is_active = !$user->is_active;
         $user->email_verified_at = now();
        $user->save();
 
        return back()->with('success', 'User status updated.');
    }
 
    // ── Mark email as verified ────────────────────────────────────────────────
    public function verifyEmail($id)
    {
        $user = User::findOrFail($id);
        $user->email_verified_at = now();
        $user->save();
 
        return back()->with('success', 'Email marked as verified.');
    }
 
    // ── Soft delete ───────────────────────────────────────────────────────────
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->is_deleted = 1;
        $user->is_active  = 0;
        $user->save();
 
        return back()->with('success', 'User deleted.');
    }
 
    // ── Restore ───────────────────────────────────────────────────────────────
    public function restore($id)
    {
        $user = User::findOrFail($id);
        $user->is_deleted = 0;
        $user->is_active  = 1;
        $user->save();
 
        return back()->with('success', 'User restored.');
    }
 
    // ── User subscriptions ────────────────────────────────────────────────────
    public function subscriptions($id)
    {
        $user          = User::findOrFail($id);
        $subscriptions = $user->subscriptions()->orderBy('created_at', 'desc')->get();
 
        return view('backend.user.subscriptions', compact('user', 'subscriptions'));
    }
}
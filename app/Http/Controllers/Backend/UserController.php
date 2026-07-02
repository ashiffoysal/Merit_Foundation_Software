<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;




class UserController extends Controller
{
    /**
     * Display a listing of the users (not soft-deleted).
     */
    public function index(Request $request)
    {
        $query = User::where('is_deleted', 0);

        // Optional search by name / email
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        return view('backend.user.index', compact('users'));
    }

    /**
     * Display a single user's details.
     */
    public function show($id)
    {
        $user = User::where('is_deleted', 0)->findOrFail($id);

        return view('users.show', compact('user'));
    }

    /**
     * Soft delete a user by flipping the is_deleted flag.
     */
    public function destroy($id)
    {
        $user = User::where('is_deleted', 0)->findOrFail($id);

        $user->update([
            'is_deleted' => 1,
        ]);

        return redirect()
            ->route('users.index')
            ->with('success', "User \"{$user->name}\" was deleted successfully.");
    }
}
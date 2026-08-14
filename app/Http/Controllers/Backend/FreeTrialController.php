<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FreeTrial;
use Carbon\Carbon;

class FreeTrialController extends Controller
{
     /**
     * GET admin.free.getindex
     * Powers the table: search, status filter, sorting, pagination, stats.
     */

     public function index(){

        return view('backend.freetrial.index');
     }
    public function getIndex(Request $request)
    {
        $search   = $request->input('search');
        $status   = $request->input('status');
        $perPage  = (int) $request->input('per_page', 10);
        $sort     = $request->input('sort', 'created_at');
        $dir      = $request->input('dir', 'desc');
 
        // Only allow sorting on real, safe columns
        $sortable = ['parent_name', 'email', 'current_level', 'status', 'created_at'];
        if (!in_array($sort, $sortable)) {
            $sort = 'created_at';
        }
        $dir = strtolower($dir) === 'asc' ? 'asc' : 'desc';
 
        $query = FreeTrial::query();
 
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('parent_name', 'like', "%{$search}%")
                  ->orWhere('child_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('whatsapp', 'like', "%{$search}%")
                  ->orWhere('country', 'like', "%{$search}%");
            });
        }
 
        if ($status) {
            $query->where('status', $status);
        }
 
        $paginated = $query->orderBy($sort, $dir)->paginate($perPage)->withQueryString();
 
        // Stats are computed independently of the current filter/search
        $stats = [
            'total'   => FreeTrial::count(),
            'new'     => FreeTrial::where('status', 'new')->count(),
            'pending' => FreeTrial::where('status', 'pending')->count(),
            'read'    => FreeTrial::where('status', 'read')->count(),
        ];
 
        return response()->json([
            'data' => $paginated->items(),
            'meta' => [
                'current_page' => $paginated->currentPage(),
                'last_page'    => $paginated->lastPage(),
                'from'         => $paginated->firstItem(),
                'to'           => $paginated->lastItem(),
                'total'        => $paginated->total(),
            ],
            'stats' => $stats,
        ]);
    }
 
    /**
     * GET admin/contact-messages/view/{id}
     */
    public function getDetails($id)
    {
        $lead = FreeTrial::findOrFail($id);
        return view('backend.freetrial.view', compact('lead'));
        // return response()->json(['message' => $item]);
    }
 
    /**
     * PATCH admin/contact-messages/{id}/status
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:new,read,pending',
        ]);
 
        $item = FreeTrial::findOrFail($id);
        $item->status = $request->input('status');
        $item->save();
 
        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully.',
        ]);
    }
 
    /**
     * DELETE admin/contact-messages/{id}
     */
    public function destroy($id)
    {
        $item = FreeTrial::find($id);
 
        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Record not found.']);
        }
 
        $item->delete();
 
        return response()->json(['success' => true, 'message' => 'Deleted successfully.']);
    }
 
    /**
     * POST contact-messages.bulk
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'ids'    => 'required|array',
            'ids.*'  => 'integer',
            'action' => 'required|in:read,pending,delete',
        ]);
 
        $ids    = $request->input('ids');
        $action = $request->input('action');
 
        if ($action === 'delete') {
            FreeTrial::whereIn('id', $ids)->delete();
            $message = count($ids) . ' record(s) deleted.';
        } else {
            FreeTrial::whereIn('id', $ids)->update(['status' => $action]);
            $message = count($ids) . ' record(s) marked as ' . $action . '.';
        }
 
        return response()->json(['success' => true, 'message' => $message]);
    }
 
    /**
     * GET contact-messages.export?type=csv|excel
     */
    public function export(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');
        $sort   = $request->input('sort', 'created_at');
        $dir    = $request->input('dir', 'desc');
 
        $sortable = ['parent_name', 'email', 'current_level', 'status', 'created_at'];
        if (!in_array($sort, $sortable)) {
            $sort = 'created_at';
        }
 
        $query = FreeTrial::query();
 
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('parent_name', 'like', "%{$search}%")
                  ->orWhere('child_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
 
        if ($status) {
            $query->where('status', $status);
        }
 
        $rows = $query->orderBy($sort, $dir)->get();
 
        $filename = 'free-trials-' . now()->format('Y-m-d') . '.csv';
 
        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];
 
        // Note: 'excel' also downloads as CSV here (Excel opens CSV natively).
        // If you need true .xlsx, install maatwebsite/excel and swap this out.
        $callback = function () use ($rows) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Parent Name', 'Child Name', 'Child Age', 'Level', 'Tutor Gender', 'Country', 'Email', 'WhatsApp', 'Preferred Time', 'Status', 'Created At']);
 
            foreach ($rows as $r) {
                fputcsv($file, [
                    $r->id,
                    $r->parent_name,
                    $r->child_name,
                    $r->child_age,
                    $r->current_level,
                    $r->tutor_gender,
                    $r->country,
                    $r->email,
                    $r->whatsapp,
                    $r->time,
                    $r->status,
                    $r->created_at,
                ]);
            }
 
            fclose($file);
        };
 
        return response()->stream($callback, 200, $headers);
    }
}

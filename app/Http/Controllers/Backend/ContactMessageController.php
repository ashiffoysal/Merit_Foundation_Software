<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactMessage;

class ContactMessageController extends Controller
{

    //contact message index
    public function index()
    {     $contactMessages = ContactMessage::latest()->get();
        return view('backend.contact_messages.index', compact('contactMessages'));
    }
    // contact message show

    public function getindex(Request $request)
    {
        if ($request->ajax()) {
            $contactMessages = ContactMessage::latest()->get();
            return response()->json(['data' => $contactMessages]);
        }
        return response()->json(['error' => 'Invalid request'], 400);
    }
    /* =====================================================
       AJAX — Paginated, Searchable, Sortable DataTable
    ===================================================== */
    public function data(Request $request)
    {
        $query = ContactMessage::query();
 
        // Search
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name',  'like', "%{$search}%")
                  ->orWhere('last_name',  'like', "%{$search}%")
                  ->orWhere('email',      'like', "%{$search}%")
                  ->orWhere('phone',      'like', "%{$search}%")
                  ->orWhere('subject',    'like', "%{$search}%")
                  ->orWhere('message',    'like', "%{$search}%");
            });
        }
 
        // Status filter
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }
 
        // Sorting
        $sortableColumns = ['first_name', 'email', 'subject', 'status', 'created_at'];
        $sort = in_array($request->input('sort'), $sortableColumns)
            ? $request->input('sort')
            : 'created_at';
        $dir = $request->input('dir') === 'asc' ? 'asc' : 'desc';
        $query->orderBy($sort, $dir);
 
        // Stats (calculated before pagination)
        $stats = [
            'total'   => (clone $query)->count(),
            'new'     => (clone $query)->where('status', 'new')->count(),
            'read'    => (clone $query)->where('status', 'read')->count(),
            'pending' => (clone $query)->where('status', 'pending')->count(),
        ];
 
        // Pagination
        $perPage = in_array((int) $request->input('per_page'), [10, 25, 50, 100])
            ? (int) $request->input('per_page')
            : 10;
 
        $paginator = $query->paginate($perPage);
 
        return response()->json([
            'data'  => $paginator->items(),
            'stats' => $stats,
            'meta'  => [
                'total'        => $paginator->total(),
                'per_page'     => $paginator->perPage(),
                'current_page' => $paginator->currentPage(),
                'last_page'    => $paginator->lastPage(),
                'from'         => $paginator->firstItem() ?? 0,
                'to'           => $paginator->lastItem() ?? 0,
            ],
        ]);
    }
 
    /* =====================================================
       AJAX — Show Single Message
    ===================================================== */
    public function show(ContactMessage $contactMessage)
    {
        // return $contactMessage;
        return response()->json([
            'message' => $contactMessage,
        ]);
    }
 
    /* =====================================================
       AJAX — Update Status
    ===================================================== */
    public function updateStatus(Request $request, ContactMessage $contactMessage)
    {
        $request->validate([
            'status' => 'required|in:new,read,pending',
        ]);
 
        $contactMessage->update(['status' => $request->status]);
 
        return response()->json([
            'success' => true,
            'message' => 'Message marked as ' . ucfirst($request->status) . '.',
        ]);
    }
 
    /* =====================================================
       AJAX — Delete Single
    ===================================================== */
    public function destroy(ContactMessage $contactMessage)
    {
        $contactMessage->delete();
 
        return response()->json([
            'success' => true,
            'message' => 'Message deleted successfully.',
        ]);
    }
 
    /* =====================================================
       AJAX — Bulk Actions (read / pending / delete)
    ===================================================== */
    public function bulk(Request $request)
    {
        $request->validate([
            'ids'    => 'required|array|min:1',
            'ids.*'  => 'integer|exists:contact_messages,id',
            'action' => 'required|in:read,pending,delete',
        ]);
 
        $ids    = $request->input('ids');
        $action = $request->input('action');
 
        switch ($action) {
            case 'read':
                ContactMessage::whereIn('id', $ids)->update(['status' => 'read']);
                $msg = count($ids) . ' message(s) marked as Read.';
                break;
            case 'pending':
                ContactMessage::whereIn('id', $ids)->update(['status' => 'pending']);
                $msg = count($ids) . ' message(s) marked as Pending.';
                break;
            case 'delete':
                ContactMessage::whereIn('id', $ids)->delete();
                $msg = count($ids) . ' message(s) deleted.';
                break;
            default:
                return response()->json(['success' => false, 'message' => 'Invalid action.'], 422);
        }
 
        return response()->json(['success' => true, 'message' => $msg]);
    }
 
    /* =====================================================
       EXPORT — CSV or Excel
    ===================================================== */
    public function export(Request $request)
    {
        $query = ContactMessage::query();
 
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }
 
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }
 
        $sortableColumns = ['first_name', 'email', 'subject', 'status', 'created_at'];
        $sort = in_array($request->input('sort'), $sortableColumns) ? $request->input('sort') : 'created_at';
        $dir  = $request->input('dir') === 'asc' ? 'asc' : 'desc';
        $query->orderBy($sort, $dir);
 
        $messages = $query->get();
        $type     = $request->input('type', 'csv');
 
        $headers = ['Name', 'Email', 'Phone', 'Subject', 'Message', 'Status', 'Date'];
        $rows    = $messages->map(fn($m) => [
            $m->first_name . ' ' . $m->last_name,
            $m->email,
            $m->phone ?? '',
            $m->subject ?? '',
            $m->message,
            ucfirst($m->status ?? 'new'),
            $m->created_at?->format('d M Y H:i'),
        ])->toArray();
 
        if ($type === 'excel') {
            return $this->exportExcel($headers, $rows);
        }
 
        return $this->exportCsv($headers, $rows);
    }
 
    private function exportCsv(array $headers, array $rows): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $filename = 'contact_messages_' . now()->format('Ymd_His') . '.csv';
 
        return Response::streamDownload(function () use ($headers, $rows) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, $headers);
            foreach ($rows as $row) {
                fputcsv($handle, $row);
            }
            fclose($handle);
        }, $filename, [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }
 
    private function exportExcel(array $headers, array $rows): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        // Simple Excel XML export — no extra package needed
        $filename = 'contact_messages_' . now()->format('Ymd_His') . '.xls';
 
        return Response::streamDownload(function () use ($headers, $rows) {
            echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
            echo '<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
                xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet">' . "\n";
            echo '<Worksheet ss:Name="Contact Messages"><Table>' . "\n";
 
            // Header row
            echo '<Row>';
            foreach ($headers as $h) {
                echo '<Cell><Data ss:Type="String">' . htmlspecialchars($h) . '</Data></Cell>';
            }
            echo '</Row>' . "\n";
 
            // Data rows
            foreach ($rows as $row) {
                echo '<Row>';
                foreach ($row as $cell) {
                    echo '<Cell><Data ss:Type="String">' . htmlspecialchars((string) $cell) . '</Data></Cell>';
                }
                echo '</Row>' . "\n";
            }
 
            echo '</Table></Worksheet></Workbook>';
        }, $filename, [
            'Content-Type'        => 'application/vnd.ms-excel',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }


public function view($id)
{
    $message = ContactMessage::find($id);
    return view('backend.contact_messages.viewpage', compact('message'));
    }
        
}

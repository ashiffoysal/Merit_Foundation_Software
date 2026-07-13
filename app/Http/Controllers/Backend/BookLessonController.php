<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BookLesson;
use Symfony\Component\HttpFoundation\StreamedResponse;

class BookLessonController extends Controller
{
    /**
     * Display a listing of all book lesson leads.
     */
    public function index()
    {
        $allleads = BookLesson::latest()->get();
 
        return view('backend.all_leads..index', compact('allleads'));
    }
 
    /**
     * Display the specified lead with full details.
     */
    public function show($id)
    {
        $lead = BookLesson::findOrFail($id);
 
        return view('backend.all_leads..show', compact('lead'));
    }
 
    /**
     * Show the form for editing the status/admin notes of the lead.
     */
    public function edit($id)
    {
        $lead = BookLesson::findOrFail($id);
 
        return view('backend.all_leads..edit', compact('lead'));
    }
 
    /**
     * Update the status/admin notes of the lead.
     */
    public function update(Request $request, $id)
    {
        $lead = BookLesson::findOrFail($id);
 
        $validated = $request->validate([
            'status'      => 'required|in:pending,contacted,trial_booked,confirmed,cancelled',
            'admin_notes' => 'nullable|string',
            'contacted_at' => 'nullable|date',
        ]);
 
        $lead->update($validated);
 
        return redirect()
            ->route('admin.book-lessons.index')
            ->with('success', 'Lead status updated successfully.');
    }
 
    /**
     * Remove the specified lead from storage.
     */
    public function destroy($id)
    {
        $lead = BookLesson::findOrFail($id);
        $lead->delete();
 
        return redirect()
            ->route('admin.book-lessons.index')
            ->with('success', 'Lead deleted successfully.');
    }
 
    /**
     * Export all leads as a CSV file.
     */
    public function export(): StreamedResponse
    {
        $fileName = 'book-lesson-leads-' . now()->format('Ymd_His') . '.csv';
 
        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename={$fileName}",
        ];
 
        $columns = [
            'ID', 'Parent Name', 'Email', 'Phone', 'Emergency Phone', 'Address',
            'Post Code', 'Student First Name', 'Student Last Name', 'Package ID',
            'Current Level', 'Preferred Tutor', 'Preferred Time', 'Notes',
            'Donation Interest', 'Status', 'Admin Notes', 'Contacted At',
            'Created At', 'Updated At',
        ];
 
        $callback = function () use ($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
 
            BookLesson::orderBy('id')->chunk(200, function ($leads) use ($file) {
                foreach ($leads as $lead) {
                    fputcsv($file, [
                        $lead->id,
                        $lead->parent_name,
                        $lead->email,
                        $lead->phone,
                        $lead->emergency_phone,
                        $lead->address,
                        $lead->post_code,
                        $lead->student_first_name,
                        $lead->student_last_name,
                        $lead->package_id,
                        $lead->current_level,
                        $lead->preferred_tutor,
                        $lead->preferred_time,
                        $lead->notes,
                        $lead->donation_interest ? 'Yes' : 'No',
                        $lead->status,
                        $lead->admin_notes,
                        $lead->contacted_at,
                        $lead->created_at,
                        $lead->updated_at,
                    ]);
                }
            });
 
            fclose($file);
        };
 
        return response()->streamDownload($callback, $fileName, $headers);
    }
}

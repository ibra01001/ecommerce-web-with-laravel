<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactMessage;


class AdminContactController extends Controller
{
    /**
     * Display all contact messages
     */
    public function index(Request $request)
    {
        $query = ContactMessage::query();

        // Filter by status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('subject', 'like', "%{$search}%")
                    ->orWhere('message', 'like', "%{$search}%");
            });
        }

        // Get counts for badges
        $newCount = ContactMessage::where('status', 'new')->count();
        $totalCount = ContactMessage::count();

        // Order by newest first
        $messages = $query->latest()->paginate(15);

        return view('admin.contact.index', compact('messages', 'newCount', 'totalCount'));
    }

    /**
     * Show a single message
     */
    public function show($id)
    {
        $message = ContactMessage::findOrFail($id);

        // Mark as read when viewed
        $message->markAsRead();

        return view('admin.contact.show', compact('message'));
    }

    /**
     * Mark message as read
     */
    public function markAsRead($id)
    {
        $message = ContactMessage::findOrFail($id);
        $message->markAsRead();

        return back()->with('success', 'Message marked as read');
    }

    /**
     * Mark multiple messages as read
     */
    public function markMultipleAsRead(Request $request)
    {
        $ids = json_decode($request->input('message_ids', '[]'), true);

        if (!is_array($ids)) {
            $ids = [];
        }

        ContactMessage::whereIn('id', $ids)
            ->where('status', 'new')
            ->update([
                'status' => 'read',
                'read_at' => now()
            ]);

        return back()->with('success', count($ids) . ' messages marked as read');
    }


    /**
     * Add admin notes to a message
     */
    public function addNote(Request $request, $id)
    {
        $message = ContactMessage::findOrFail($id);

        $validated = $request->validate([
            'admin_notes' => 'required|string|max:1000'
        ]);

        $message->update([
            'admin_notes' => $validated['admin_notes']
        ]);

        return back()->with('success', 'Note added successfully');
    }

    /**
     * Delete a message
     */
    public function destroy($id)
    {
        $message = ContactMessage::findOrFail($id);
        $message->delete();

        return back()->with('success', 'Message deleted successfully');
    }

    /**
     * Delete multiple messages
     */
    public function destroyMultiple(Request $request)
    {
        $ids = json_decode($request->input('message_ids', '[]'), true);

        if (!is_array($ids)) {
            $ids = [];
        }

        ContactMessage::whereIn('id', $ids)->delete();

        return back()->with('success', count($ids) . ' messages deleted');
    }

    /**
     * Export messages to CSV
     */
    public function export(Request $request)
    {
        $query = ContactMessage::query();

        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $messages = $query->latest()->get();

        $filename = 'contact_messages_' . date('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        $callback = function () use ($messages) {
            $file = fopen('php://output', 'w');

            // Header row
            fputcsv($file, ['ID', 'Name', 'Email', 'Phone', 'Subject', 'Message', 'Status', 'Submitted At', 'Read At']);

            // Data rows
            foreach ($messages as $message) {
                fputcsv($file, [
                    $message->id,
                    $message->name,
                    $message->email,
                    $message->phone,
                    $message->subject,
                    $message->message,
                    $message->status,
                    $message->created_at->format('Y-m-d H:i:s'),
                    $message->read_at ? $message->read_at->format('Y-m-d H:i:s') : 'Not read'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
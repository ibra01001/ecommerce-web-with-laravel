<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AdminNewsletterController extends Controller
{
    public function index()
    {
        $subscribers = DB::table('newsletter_subscribers')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.newsletter.index', compact('subscribers'));
    }

    public function delete($id)
    {
        DB::table('newsletter_subscribers')->where('id', $id)->delete();

        return back()->with('success', 'Subscriber deleted successfully.');
    }
}

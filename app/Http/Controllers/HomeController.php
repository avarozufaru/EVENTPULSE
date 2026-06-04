<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $categories = DB::table('categories')->get();

        // Query events
        $query = DB::table('events')->where('status', 'published');

        // Filter by category
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        // Sort by closest date (Upcoming events first)
        $events = $query->orderBy('tanggal', 'asc')->get();

        // Fetch featured events
        $featuredEvents = DB::table('events')
            ->where('is_featured', 1)
            ->where('status', 'published')
            ->get();

        return view('home', compact('events', 'categories', 'featuredEvents'));
    }

    public function detail($id)
    {
        $event = DB::table('events')
            ->where('id', $id)
            ->first();

        if (!$event) {
            abort(404);
        }

        // Calculate remaining quota
        $registeredCount = DB::table('registrations')
            ->where('event_id', $id)
            ->count();

        $remainingQuota = $event->kuota - $registeredCount;

        return view('detail-event', compact('event', 'remainingQuota'));
    }
}
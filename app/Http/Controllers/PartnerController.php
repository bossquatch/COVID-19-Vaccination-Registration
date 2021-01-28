<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PartnerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['verified', 'can:read_partner_event']);
    }

    public function index()
    {
        $partner_tags = Auth::user()->tags()->pluck('id')->toArray();
        $events = \App\Models\Event::where('date_held', '>=', DB::raw('CURDATE()'))->whereHas('tags', function ($query) use ($partner_tags) {
                $query->whereIn('id', $partner_tags);
            })->orderBy('date_held', 'asc')->orderBy('created_at', 'asc')->paginate(config('app.pagination_limit'));

        return view('partner.index', [
            'events' => $events,
        ]);
    }

    public function history()
    {
        $partner_tags = Auth::user()->tags()->pluck('id')->toArray();
        $events = \App\Models\Event::where('date_held', '<', DB::raw('CURDATE()'))->whereHas('tags', function ($query) use ($partner_tags) {
                $query->whereIn('id', $partner_tags);
            })->orderBy('date_held', 'asc')->orderBy('created_at', 'asc')->paginate(config('app.pagination_limit'));

        return view('partner.history', [
            'events' => $events,
        ]);
    }
}

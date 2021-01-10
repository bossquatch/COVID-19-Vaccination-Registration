<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ManageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['verified', 'can:read_registration']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('manage.index');
    }

    public function searchName()
    {
        return response()->json($this->searchResults(\App\Models\Registration::where(DB::raw('CONCAT_WS(" ",first_name,last_name)'), 'LIKE', '%'.request()->input('val').'%')->get()));
    }

    public function searchAddr()
    {
        return response()->json($this->searchResults(\App\Models\Registration::where(DB::raw('CONCAT_WS(" ",address1,address2,city,state,zip)'), 'LIKE', '%'.request()->input('val').'%')->get()));
    }

    public function searchRegis()
    {
        return response()->json($this->searchResults(\App\Models\Registration::where('id', '=', request()->input('val'))->get()));
    }

    public function searchCode()
    {
        return response()->json($this->searchResults(\App\Models\Registration::where('code', 'LIKE', '%'.request()->input('val').'%')->get()));
    }

    private function searchResults($results)
    {
        $html = '';

        foreach($results as $res) {
            $html .= '<tr><td>'.$res->first_name.' '.$res->last_name.'</td><td>'.$res->id.'</td><td>'.$res->code.'</td><td>'.Carbon::parse($res->submitted_at)->format('m-d-Y h:i:s A').'</td><td>'.$res->status->name.'</td></tr>';
        }

        if ($html == '') {
            $html = '<td colspan="5"><div class="alert alert-warning">No registrations were found!</div></td>';
        }

        return ['result' => $html];
    }
}

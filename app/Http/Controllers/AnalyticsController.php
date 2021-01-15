<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['verified', 'can:keep_inventory']);
    }

    public function index()
    {
        // registered by day
        $registered_by_day = [
            'dates' => [],
            'self' => [],
            'call-center' => []
        ];
        $registered_by_day_db = DB::select('
            SELECT 
                date(r.created_at) `Date`,
                count(*) `Count`,
                SUM(IF(u.email like \'%@%\',1,0)) `Self Serve`,
                SUM(IF(u.email not like \'%@%\',1,0)) `Call Center`
            FROM 
                registrations r 
                JOIN users u ON u.id = r.user_id
            GROUP BY
                date(r.created_at)');

        foreach($registered_by_day_db as $day) {
            $registered_by_day['dates'][] = Carbon::parse($day->{'Date'})->isoFormat('MMM D');
            $registered_by_day['self'][] = $day->{'Self Serve'};
            $registered_by_day['call-center'][] = $day->{'Call Center'};
        }

        // registrations by county
        $registered_by_county = [
            'counts' => [],
            'counties' => []
        ];
        $registered_by_county_db = DB::select('
            SELECT
                count(r.id) `Count`,
                c.county `County`
            FROM
                registrations r
                JOIN counties c ON r.county_id = c.id
            GROUP BY
                c.county
        ');

        $other_fl_counties = 0;
        foreach($registered_by_county_db as $county) {
            if ($county->Count >= 25 || in_array($county->County, ['Polk', 'Unknown', 'Outside of Florida'])) {
                $registered_by_county['counts'][] = $county->Count;
                $registered_by_county['counties'][] = $county->County;
            } else {
                $other_fl_counties += $county->Count;
            }
        }
        $registered_by_county['counts'][] = $other_fl_counties;
        $registered_by_county['counties'][] = 'Other Florida Counties';

        // registrations by cities in Polk
        $registered_by_city = [
            'counts' => [],
            'cities' => [],
        ];
        $registered_by_city_db = DB::select('
            SELECT
                count(r.id) `Count`,
                r.city `City`
            FROM
                registrations r
                JOIN counties c ON r.county_id = c.id
            WHERE
                c.county = \'Polk\'
            GROUP BY
                r.city
        ');

        foreach($registered_by_city_db as $city) {
            $registered_by_city['counts'][] = $city->Count;
            $registered_by_city['cities'][] = $city->City;
        }

        return view('analytics.index', [
            'register_by_day' => $registered_by_day,
            'register_by_county' => $registered_by_county,
            'register_by_city' => $registered_by_city,
        ]);
    }
}

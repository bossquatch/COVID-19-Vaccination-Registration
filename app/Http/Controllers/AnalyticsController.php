<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;

class AnalyticsController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['verified', 'can:keep_inventory'])->except([
            'publicAnalytics'
        ]);
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
                SUM(IF(u.email_verified_at IS NOT NULL,1,0)) `Self Serve`,
                SUM(IF(u.email_verified_at IS NULL,1,0)) `Call Center`
            FROM
                registrations r
                JOIN users u ON u.id = r.user_id
            WHERE
            	r.deleted_at IS NULL
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
                WITH top10 AS
                (
                    SELECT
                        COUNT(*) AS `Count`,
                        c.name AS `County`
                    FROM
                        registrations r
                        JOIN addresses a ON r.address_id = a.id
                        JOIN counties c ON a.county_id = c.id
					WHERE
						r.deleted_at IS NULL
                    GROUP BY c.id
                    ORDER BY 1 DESC LIMIT 10
                )

                SELECT * FROM top10

                UNION ALL

                SELECT
                count(*),
                \'Other FL Counties\'
                FROM
                registrations r
                JOIN addresses a ON r.address_id = a.id
                JOIN counties c ON a.county_id = c.id
                WHERE c.name NOT IN (select County from top10)
        ');

        foreach($registered_by_county_db as $county) {
            $registered_by_county['counts'][] = $county->Count;
            $registered_by_county['counties'][] = Str::of($county->County)->title().' ('.$county->Count.')';
        }

        // registrations by cities in Polk
        $registered_by_city = [
            'counts' => [],
            'cities' => [],
        ];
        $registered_by_city_db = DB::select('
            SELECT
                upper(r.city) `City`,
                count(*) `Count`

            FROM
                registrations r

            WHERE
            	r.deleted_at IS NULL

            GROUP BY
                r.city

            HAVING
                count(*) > 99

            ORDER BY
                count(*) desc;

        ');

        foreach($registered_by_city_db as $city) {
            $registered_by_city['counts'][] = $city->Count;
            $registered_by_city['cities'][] = Str::of($city->City)->title().' ('.$city->Count.')';
        }

        return view('analytics.index', [
            'register_by_day' 		=> $registered_by_day,
            'register_by_county' 	=> $registered_by_county,
            'register_by_city' 		=> $registered_by_city,
            'registrations_today' 	=> DB::select('SELECT COUNT(*) `Count` FROM registrations WHERE DATE(`submitted_at`) = DATE(DATE_ADD(NOW() AND `deleted_at` IS NULL, INTERVAL -5 HOUR))')[0]->Count,
            'registrations_total' 	=> DB::select('SELECT COUNT(*) `Count` FROM registrations WHERE `deleted_at` IS NULL')[0]->Count,
            'registrations_old' 	=> DB::select('SELECT COUNT(*) `Count` FROM registrations WHERE DATE(`birth_date`) <= DATE_SUB(CURDATE(), INTERVAL 65 YEAR) AND `deleted_at` IS NULL')[0]->Count,
            'registrations_young' 	=> DB::select('SELECT COUNT(*) `Count` FROM registrations WHERE DATE(`birth_date`) > DATE_SUB(CURDATE(), INTERVAL 65 YEAR) AND `deleted_at` IS NULL')[0]->Count,
        ]);
    }

    public function publicAnalytics()
    {
        //  check the cache for the existence of this data.  If found, use cache; if not, run the queries and store in cache
        if (Cache::has('registrationsByDay') == false) {

            $registrations = [
                'counts' => [],
                'day' => []
            ];

            $regByDay = DB::select("
                SELECT
                    DATE_FORMAT(r.submitted_at,'%m/%d/%y') `Day`,
                    count(*) `Count`
                FROM
                    registrations r
                WHERE
                    r.deleted_at IS NULL
                GROUP BY
                    DATE_FORMAT(r.submitted_at,'%m/%d/%y')
            ");

            foreach ($regByDay as $day) {
                $registrations['counts'][] = $day->Count;
                $registrations['day'][] = $day->Day;
            }

//            $currentSchedule = Carbon::create(Registration::where('status_id', '=', 2)->max('submitted_at'));
            $currentSchedule = Carbon::create('2021-02-18');

            Cache::tags(['analytics'])->put('registrationsByDay', $registrations, $seconds = 600);
            Cache::tags(['analytics'])->put('currentSchedule', $currentSchedule, $seconds = 600);

        }

        return view('home.index',[
            'currentSchedule' => Cache::tags(['analytics'])->get('currentSchedule')->format('F jS, Y'),
            'registrations' => Cache::tags(['analytics'])->get('registrationsByDay'),
        ]);
    }

}

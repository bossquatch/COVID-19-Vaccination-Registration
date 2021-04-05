<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;

class AnalyticsController extends Controller
{

	// global timeout for the cache, in seconds
	protected $timeout;

    public function __construct()
    {
        $this->middleware(['verified', 'can:keep_inventory'])->except([
            'publicAnalytics'
        ]);

        $this->timeout = Config::get('app.analytics_refresh');
    }

    public function index()
    {
        return view('analytics.index', [
            'register_by_day' 		=> $this->registrationsByDay(),
            'register_by_county' 	=> $this->registrationsByCounty(),
            'register_by_city' 		=> $this->registrationsByLocality(),
            'registrations_today' 	=> $this->registrationsToday(),
            'registrations_total' 	=> $this->registrationsTotal(),
            'registrations_old' 	=> $this->registrationsOld (),
            'registrations_young' 	=> $this->registrationsYoung(),
	        'registrations_by_age'  => $this->registrationsByAgeGroup (),
        ]);
    }

    private function registrationsByDay(): array
    {

	    if (Cache::tags(['analytics'])->has('registrationsByDay') == false) {

		    $registrations = [
			    'dates' => [],
			    'organic' => [],
			    'call-center' => []
		    ];

		    // grab em
		    $registrationsAll = DB::select('
	            SELECT
	                date(r.created_at) `Date`,
	                count(*) `Count`,
	                SUM(IF(u.email_verified_at IS NOT NULL,1,0)) `Self Serve`,
	                SUM(IF(u.email_verified_at IS NULL,1,0)) `Call Center`
	            FROM registrations r
	            JOIN users u ON u.id = r.user_id
	            WHERE r.deleted_at IS NULL
	            GROUP BY date(r.created_at)
			');

		    // split em
		    foreach($registrationsAll as $day) {
			    $registrations['dates'][] = Carbon::parse($day->{'Date'})->isoFormat('MMM D');
			    $registrations['organic'][] = $day->{'Self Serve'};
			    $registrations['call-center'][] = $day->{'Call Center'};
		    }

		    // cache em
		    Cache::tags(['analytics'])->put('registrationsByDay', $registrations, $seconds = $this->timeout);

		    // return em
		    return $registrations;

	    } else {
		    // grab em from cache, return em
		    return Cache::tags(['analytics'])->get('registrationsByDay');
	    }

    }

    private function registrationsByCounty(): array
    {

	    if (Cache::tags(['analytics'])->has('registrationsByCounty') == false) {

		    $registrations = [
			    'counts' => [],
			    'counties' => []
		    ];

		    // grab em
		    $registrationsAll = DB::select('
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
	                FROM registrations r
	                JOIN addresses a ON r.address_id = a.id
	                JOIN counties c ON a.county_id = c.id
	                WHERE c.name NOT IN (select County from top10)
	                AND r.deleted_at IS NULL
	        ');

		    // split em
		    foreach($registrationsAll as $county) {
			    $registrations['counts'][] = $county->Count;
			    $registrations['counties'][] = Str::of($county->County)->title().' ('.$county->Count.')';
		    }

		    // cache em
		    Cache::tags(['analytics'])->put('registrationsByCounty', $registrations, $seconds = $this->timeout);

		    // return em
		    return $registrations;

	    } else {
		    // grab em from cache, return em
		    return Cache::tags(['analytics'])->get('registrationsByCounty');
	    }

    }

    private function registrationsByLocality(): array
    {

	    if (Cache::tags(['analytics'])->has('registrationsByLocality') == false) {

		    $registrations = [
			    'counts' => [],
			    'cities' => [],
		    ];

		    // grab em
		    $registrationsAll = DB::select('
	            SELECT
	                upper(a.locality) AS `City`,
	                count(*) AS `Count`
	            FROM registrations r
	            JOIN addresses a ON r.address_id = a.id
	            JOIN counties c ON a.county_id = c.id
	            WHERE r.deleted_at IS NULL
	            AND c.`name` = \'Polk\'
	            GROUP BY a.locality
	            HAVING count(*) > 999
	            ORDER BY count(*) desc;
			');

		    // split em
		    foreach($registrationsAll as $city) {
			    $registrations['counts'][] = $city->Count;
			    $registrations['cities'][] = Str::of($city->City)->title().' ('.$city->Count.')';
		    }

		    // cache em
		    Cache::tags(['analytics'])->put('registrationsByLocality', $registrations, $seconds = $this->timeout);

		    // return em
		    return $registrations;

	    } else {
		    // grab em from cache, return em
		    return Cache::tags(['analytics'])->get('registrationsByLocality');
	    }

    }

    private function registrationsToday(): int
    {

	    if (Cache::tags(['analytics'])->has('registrationsToday') == false) {

		    // grab em
		    $registrations = DB::select('
				SELECT COUNT(*) `Count`
				FROM registrations
				WHERE `deleted_at` IS NULL
				  AND DATE(`submitted_at`) = DATE(DATE_ADD(NOW(), INTERVAL -5 HOUR))
			')[0]->Count;

		    // cache em
		    Cache::tags(['analytics'])->put('registrationsToday', $registrations, $seconds = $this->timeout);

		    // return em
		    return $registrations;

	    } else {
		    // grab em from cache, return em
		    return Cache::tags(['analytics'])->get('registrationsToday');
	    }
    }

    private function registrationsTotal(): int
    {

	    if (Cache::tags(['analytics'])->has('registrationsTotal') == false) {

		    // grab em
		    $registrations = DB::select('
				SELECT COUNT(*) `Count`
				FROM registrations
				WHERE `deleted_at` IS NULL
			')[0]->Count;

		    // cache em
		    Cache::tags(['analytics'])->put('registrationsTotal', $registrations, $seconds = $this->timeout);

		    // return em
		    return $registrations;

	    } else {
		    // grab em from cache, return em
		    return Cache::tags(['analytics'])->get('registrationsTotal');
	    }

    }

    private function registrationsOld(): int
    {

	    if (Cache::tags(['analytics'])->has('registrationsOld') == false) {

		    // grab em
		    $registrations = DB::select('
				SELECT COUNT(*) `Count`
				FROM registrations
				WHERE `deleted_at` IS NULL
				  AND DATE(`birth_date`) <= DATE_SUB(CURDATE(), INTERVAL 65 YEAR)
			')[0]->Count;

		    // cache em
		    Cache::tags(['analytics'])->put('registrationsOld', $registrations, $seconds = $this->timeout);

		    // return em
		    return $registrations;

	    } else {
		    // grab em from cache, return em
		    return Cache::tags(['analytics'])->get('registrationsOld');
	    }

    }

    private function registrationsYoung(): int
    {

	    if (Cache::tags(['analytics'])->has('registrationsYoung') == false) {

	    	// grab em
		    $registrations = DB::select ('
				SELECT COUNT(*) `Count`
				FROM registrations
				WHERE `deleted_at` IS NULL
				  AND DATE(`birth_date`) > DATE_SUB(CURDATE(), INTERVAL 65 YEAR)
			')[0]->Count;

		    // cache em
		    Cache::tags(['analytics'])->put('registrationsYoung', $registrations, $seconds = $this->timeout);

		    // return em
		    return $registrations;

	    } else {
			// grab em from cache, return em
		    return Cache::tags(['analytics'])->get('registrationsYoung');
	    }
    }

	public function publicAnalytics()
	{
		//  check the cache for the existence of this data.  If found, use cache; if not, run the queries and store in cache
		if (Cache::tags(['analytics'])->has('registrationsByDayPublic') == false || Cache::tags(['analytics'])->has('currentSchedule') == false) {

			$registrations = [
				'counts' => [],
				'day'    => []
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
				$registrations['counts'][]  = $day->Count;
				$registrations['day'][]     = $day->Day;
			}

			$currentSchedule = Carbon::create(Config::get('app.current_vaccination_date'));

			Cache::tags(['analytics'])->put('registrationsByDayPublic', $registrations, $seconds = $this->timeout);
			Cache::tags(['analytics'])->put('currentSchedule', $currentSchedule, $seconds = $this->timeout);

		}

		return view('home.index',[
			'currentSchedule'   => Cache::tags(['analytics'])->get('currentSchedule')->format('F jS, Y'),
			'registrations'     => Cache::tags(['analytics'])->get('registrationsByDayPublic'),
		]);
	}

	public function registrationsByAgeGroup(): array
	{
		if (Cache::tags(['analytics'])->has('registrationsByAgeGroup') == false) {

			// grab em
			$registrationsAll = DB::select('
				SELECT
					s.`name` `Status`,
					SUM(IF(r.birth_date <= DATE_SUB(now(), INTERVAL 65 YEAR),1,0)) `65+`,
					SUM(IF(r.birth_date BETWEEN DATE_SUB(NOW(), INTERVAL 64 YEAR) AND DATE_SUB(NOW(), INTERVAL 60 YEAR),1,0)) `60-64`,
					SUM(IF(r.birth_date BETWEEN DATE_SUB(NOW(), INTERVAL 59 YEAR) AND DATE_SUB(NOW(), INTERVAL 50 YEAR),1,0)) `50-59`,
					SUM(IF(r.birth_date BETWEEN DATE_SUB(NOW(), INTERVAL 49 YEAR) AND DATE_SUB(NOW(), INTERVAL 40 YEAR),1,0)) `40-49`,
					SUM(IF(r.birth_date BETWEEN DATE_SUB(NOW(), INTERVAL 39 YEAR) AND DATE_SUB(NOW(), INTERVAL 30 YEAR),1,0)) `30-39`,
					SUM(IF(r.birth_date BETWEEN DATE_SUB(NOW(), INTERVAL 29 YEAR) AND DATE_SUB(NOW(), INTERVAL 18 YEAR),1,0)) `18-29`,
				    SUM(IF(r.birth_date BETWEEN DATE_SUB(NOW(), INTERVAL 17 YEAR) AND DATE_SUB(NOW(), INTERVAL 16 YEAR),1,0)) `16-17`,
					SUM(IF(r.birth_date > DATE_SUB(now(), INTERVAL 16 YEAR),1,0)) `15-`,
					count(*) `Total`

				FROM
					registrations r
					JOIN statuses s ON s.id = r.status_id
					JOIN addresses a on r.address_id = a.id
					JOIN states s2 on a.state_id = s2.id
					LEFT JOIN fl_shots_registrations fl ON fl.registration_id = r.id

				WHERE
				      r.deleted_at IS NULL
				AND
				      s2.abbr = "FL"
				AND
				      fl.registration_id IS NULL

				GROUP BY
				         s.id

				ORDER BY
				         s.id;
			');

			$registrations = [
				'65+'   => Arr::pluck($registrationsAll, '65+','Status'),
				'60-64' => Arr::pluck($registrationsAll, '60-64','Status'),
				'50-59' => Arr::pluck($registrationsAll, '50-59','Status'),
				'40-49' => Arr::pluck($registrationsAll, '40-49','Status'),
				'30-39' => Arr::pluck($registrationsAll, '30-39','Status'),
				'18-29' => Arr::pluck($registrationsAll, '18-29','Status'),
				'16-17' => Arr::pluck($registrationsAll, '16-17','Status'),
				'15-'   => Arr::pluck($registrationsAll, '15-','Status'),
				'Total' => Arr::pluck($registrationsAll, 'Total','Status'),
			];

			// cache em
			Cache::tags(['analytics'])->put('registrationsByAgeGroup', $registrations, $seconds = $this->timeout);

			// return em
			return $registrations;

		} else {
			// grab em from cache, return em
			return Cache::tags(['analytics'])->get('registrationsByAgeGroup');
		}
	}

}

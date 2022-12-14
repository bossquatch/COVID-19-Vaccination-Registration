<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
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

    public function searchName()
    {
    	$input = request()->input('val');

    	// check for a valid date
    	if(strtotime($input))
	    {
		    $data = Carbon::parse ($input);
		    return response()->json($this->searchByBirthdate($data));
	    } else {
    		return response()->json ($this->searchByName ($input));
	    }
    }

    private function searchByName($data)
    {
	    return $this->searchResults(
			    User::whereHas('roles', function (Builder $query) {
				    $query->where('name', '=', 'user');
			    })->where(DB::raw('CONCAT_WS(" ",first_name,last_name)'), 'LIKE', '%'.$data.'%'),
			    request()->input('offset'),
			    request()->input('sort'),
			    request()->input('filter'),
			    request()->input('showDeleted')
	    );
    }

    private function searchByBirthdate($data)
    {
	    return $this->searchResults(
			    User::whereHas('roles', function (Builder $query) {
				    $query->where('name', '=', 'user');
			    })->where(DB::raw('CONCAT_WS(" ",birth_date)'), '=', $data->format('Y-m-d')),
			    request()->input('offset'),
			    request()->input('sort'),
			    request()->input('filter'),
			    request()->input('showDeleted')
	    );
    }

    public function searchAddr()
    {
        return response()->json(
            $this->searchResults(
                User::whereHas('registration', function (Builder $query) {
                    $query->whereHas('address', function (Builder $query) {
                        $query->where(DB::raw('CONCAT_WS(" ",street_number,street_name,locality,(SELECT states.abbr FROM states where states.id = addresses.state_id),postal_code)'), 'LIKE', '%'.request()->input('val').'%');
                    });
                }),
                request()->input('offset'),
                request()->input('sort'),
                request()->input('filter'),
                request()->input('showDeleted')
            )
        );
    }

    public function searchRegis()
    {
        return response()->json(
            $this->searchResults(
                User::whereHas('registration', function (Builder $query) {
                    $query->where('id', '=', request()->input('val'));
                }),
                request()->input('offset'),
                request()->input('sort'),
                request()->input('filter'),
                request()->input('showDeleted')
            )
        );
    }

    public function searchCode()
    {
        return response()->json(
            $this->searchResults(
                User::whereHas('registration', function (Builder $query) {
                    $query->where('code', 'LIKE', '%'.request()->input('val').'%');
                }),
                request()->input('offset'),
                request()->input('sort'),
                request()->input('filter'),
                request()->input('showDeleted')
            )
        );
    }

    private function searchResults($query, $offset, $sort, $filter, $withTrashed)
    {
        $limit = config('app.pagination_limit');
        if ($filter != 'All') {
            $query = $query->whereHas('registration', function (Builder $query) use ($filter) {
                    $query->whereHas('status', function (Builder $query) use ($filter) {
                            $query->where('name', '=', $filter);
                        });
                });
        }
        if ($withTrashed && (Auth::user()->permissions()->contains('keep_inventory') || Auth::user()->permissions()->contains('skeleton_key'))) {
            $query = $query->withTrashed();
        }
        $total_count = $query->count();
        $res = $query->select('*', DB::raw('(SELECT registrations.submitted_at FROM registrations WHERE registrations.user_id = users.id AND registrations.deleted_at IS NULL LIMIT 1) as submitted_at'))->orderBy('submitted_at', $sort ?? 'asc')->offset($offset)->limit($limit)->get();
        $pagination = '';

        if ($total_count > 0) {
            $html = view('manage.partials.tablerow', ['results' => $res])->render();

            if ($total_count > $limit) {
                $pagination = view('manage.partials.paginationrow', ['top' => (($offset + $limit) > $total_count ? $total_count : ($offset + $limit)), 'bot' => $offset + 1, 'total' => $total_count])->render();
            }
        } else {
            $html = '<td colspan="7"><div class="alert alert-warning">No registrations were found!</div></td>';
        }

        return [
            'result' => $html,
            'offset' => $offset + $limit,
            'limit' => $limit,
            'pagination' => $pagination,
        ];
    }
}

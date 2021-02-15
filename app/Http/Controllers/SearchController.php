<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

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
        return response()->json(
            $this->searchResults(
                \App\Models\User::whereHas('roles', function (Builder $query) {
                    $query->where('name', '=', 'user');
                })->where(DB::raw('CONCAT_WS(" ",first_name,last_name)'), 'LIKE', '%'.request()->input('val').'%'),
                request()->input('offset'),
                request()->input('sort'),
                request()->input('filter')
            )
        );
    }

    public function searchAddr()
    {
        return response()->json(
            $this->searchResults(
                \App\Models\User::whereHas('registration', function (Builder $query) {
                    $query->whereHas('address', function (Builder $query) {
                        $query->where(DB::raw('CONCAT_WS(" ",street_number,street_name,locality,(SELECT states.abbr FROM states where states.id = addresses.state_id),postal_code)'), 'LIKE', '%'.request()->input('val').'%');
                    });
                }),
                request()->input('offset'),
                request()->input('sort'),
                request()->input('filter')
            )
        );
    }

    public function searchRegis()
    {
        return response()->json(
            $this->searchResults(
                \App\Models\User::whereHas('registration', function (Builder $query) {
                    $query->where('id', '=', request()->input('val'));
                }),
                request()->input('offset'),
                request()->input('sort'),
                request()->input('filter')
            )
        );
    }

    public function searchCode()
    {
        return response()->json(
            $this->searchResults(
                \App\Models\User::whereHas('registration', function (Builder $query) {
                    $query->where('code', 'LIKE', '%'.request()->input('val').'%');
                }),
                request()->input('offset'),
                request()->input('sort'),
                request()->input('filter')
            )
        );
    }

    private function searchResults($query, $offset, $sort, $filter)
    {
        $limit = config('app.pagination_limit');
        if ($filter != 'All') {
            $query = $query->whereHas('registration', function (Builder $query) use ($filter) {
                    $query->whereHas('status', function (Builder $query) use ($filter) {
                            $query->where('name', '=', $filter);
                        });
                });
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

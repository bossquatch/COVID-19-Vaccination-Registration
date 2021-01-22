<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['verified', 'can:read_user']);
    }

    public function index()
    {
        $users = \App\Models\User::select('users.id as id', 'first_name', 'last_name', 'email', 'roles.label as role')
            ->leftJoin('role_user', 'users.id', '=', 'role_user.user_id')
            ->leftJoin('roles', 'role_user.role_id', '=', 'roles.id')
            ->where('roles.id', '!=', '1')->orderBy('roles.id', 'desc')->orderBy('id', 'asc')->get();

        return view('admin.index', [
            'users' => $users,
        ]);
    }

    public function report()
    {
        return view('admin.reports');
    }

    public function create()
    {
        $roles = \App\Models\Role::select('name', 'label')->where('name', '!=', 'user')->get();
        $user = null;
        $userRole = null;

        return view('admin.new', [
            'user' => $user,
            'roles' => $roles,
            'userRole' => $userRole,
        ]);
    }

    public function store()
    {
        $submitted = $this->validateUser();

        $user = new \App\Models\User();

        $user->email = $submitted['email'];
        $user->first_name = $submitted['firstName'];
        if (array_key_exists('middleName', $submitted)) {
            $user->middle_name = $submitted['middleName'];
        } else {
            $user->middle_name = null;
        }
        $user->last_name = $submitted['lastName'];
        $user->password = Hash::make(Str::random(12));
        $user->email_verified_at = now();
        $user->save();
        $user->roles()->sync(\App\Models\Role::whereName($submitted['role'])->firstOrFail());

        $this->logChanges($user, 'created', false, false, ['role_assigned' => $submitted['role']], true);

        $user->forceReset();

        \Session::flash('success', "User was successfully added.  The user will be prompted to change their password the first time they try to log in (within the next hour).");
        return redirect('/admin');
    }

    public function edit($id)
    {
        $user = \App\Models\User::findOrFail($id);
        $roles = \App\Models\Role::select('name', 'label')->where('name', '!=', 'user')->get();

        $userRole = $user->roles()->first();
        
        // Fail check, will look into what to do with public users
        if ($userRole != null && $userRole->name == 'user') {
            abort(404);
        }

        return view('admin.edit', [
            'user' => $user,
            'roles' => $roles,
            'userRole' => $userRole,
        ]);
    }

    public function update($id)
    {
        $submitted = $this->validateUser($id);

        $user = \App\Models\User::findOrFail($id);

        $userRole = $user->roles()->first();
        
        if ($userRole != null && $userRole->name == 'user') {
            abort(404);
        }

        $user->email = $submitted['email'];
        $user->first_name = $submitted['firstName'];
        if (array_key_exists('middleName', $submitted)) {
            $user->middle_name = $submitted['middleName'];
        } else {
            $user->middle_name = null;
        }
        $user->last_name = $submitted['lastName'];
        $user->roles()->sync(\App\Models\Role::whereName($submitted['role'])->firstOrFail());

        $user->save();

        $this->logChanges($user, 'updated', false, false, ['role_assigned' => $submitted['role']], true);

        \Session::flash('success', "User was successfully updated.");
        return redirect('/admin');
    }

    public function delete($id)
    {
        $user = \App\Models\User::findOrFail($id);

        $this->logChanges($user, 'deleted', false, false, null, true);

        $user->delete();

        \Session::flash('success', "User was successfully deleted.");
        return redirect('/admin');
    }

    public function resetPassword()
    {
        if (request()->input("userId")) {
            $user = \App\Models\User::find(request()->input("userId"));
            if ($user) {
                $user->forceReset();
                return json_encode(['status' => 'success', 'html' => view('admin.partials.reset.success')->render()]);
            }
        } 
        
        return json_encode(['status' => 'fail', 'html' => view('admin.partials.reset.fail')->render()]);
    }

    private function validateUser($id = null) 
    {
        $valid_roles = implode(",",\App\Models\Role::where('name', '!=', 'user')->pluck('name')->toArray());

        if ($id == null) {
            return request()->validate([
                'email' => 'required|max:191|email:filter|unique:users',
                'firstName' => 'required|max:30',
                'middleName' => 'nullable|max:30',
                'lastName' => 'required|max:30',
                'role' => 'required|in:'.$valid_roles,
            ]);
        } else {
            return request()->validate([
                'email' => 'required|max:191|email:filter|unique:users,email,'.$id,
                'firstName' => 'required|max:30',
                'middleName' => 'nullable|max:30',
                'lastName' => 'required|max:30',
                'role' => 'required|in:'.$valid_roles,
            ]);
        }
    }
}

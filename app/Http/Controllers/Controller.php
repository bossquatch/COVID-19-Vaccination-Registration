<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //=======================================================================================================================================
    // $model is for the model that was changed
    // $status is basic, one word description for the log (i.e. 'created', 'updated', 'deleted', etc.)
    // $registrationModel is marking whether or not $model is of App\Models\Registration
    // $userModelRegistered is marking whether or not $model is of App\Models]User and just got registered (not for creating through Procurators)
    // $extra is any extra information that needs to be added to the log
    // Compatible Models: Registration, User
    //=======================================================================================================================================
    public function logChanges(Model $model, $status, $registrationModel = false, $userModelRegistered = false, $extra = null, $adminUserChanges = false)
    {
        if ($model->wasChanged() || $model->wasRecentlyCreated || $status == 'deleted'){
            if ($model->wasRecentlyCreated) {
                if ($extra) {
                    $extra['wasRecentlyCreated'] = '1';
                } else {
                    $extra = ['wasRecentlyCreated' => '1'];
                }
            }
            $arr = $extra ? [
                'status' => $status,
                'values' => empty($model->getChanges()) ? $model->getOriginal() : $model->getChanges(),
                'extra' => $extra
            ] : [
                'status' => $status,
                'values' => empty($model->getChanges()) ? $model->getOriginal() : $model->getChanges()
            ];

            $log = new \App\Models\AuditLog([
                'user_id' => $userModelRegistered ? $model->id : Auth::id(),
                'regis_id' => !($userModelRegistered || $adminUserChanges) ? ($registrationModel ? $model->id : ($model->registration ? $model->registration->id : null)) : null,
                'json_description' => json_encode($arr),
                'json_ips' => json_encode(request()->ips()),
            ]);

            $model->AuditChanges()->save($log);
        }
    }

    /*
    // System will not work this way this time
    public function getUserApplication()
    {
        $user = Auth::user();
        $application = $user->Application;

        if ($application == null) {
            $application = $user->Application()->create([
                'status_id' => '11',
            ]);

            $this->logChanges($application, 'created', true);

            $applicant = \App\Applicant::create([
                'first_name' => $user->first_name,
                'middle_name' => $user->middle_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'app_id' => $application->id,
            ]);

            $this->logChanges($applicant, 'created');
        }

        return $application;
    }
    */

    protected function changePassword($userId, $newPwd)
    {
        $user = \App\Models\User::findOrFail($userId);
        $user->password = Hash::make($newPwd);
        $user->save();
        $this->logChanges($user, 'updated', false, false, null, true);

        return $user;
    }
}

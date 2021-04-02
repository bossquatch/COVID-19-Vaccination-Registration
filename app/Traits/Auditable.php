<?php

/*  *   *   *   *   *   *   *   *   *   *  *   *   *   *   *   *   *   *   *   *  *   *   *   *   *   *   *   *   *   *
 *  Auditable Trait
 *  Purpose: add the auditable and logging listeners just by adding the trait
 *  STATUS: IN PROGRESS; DO NOT USE IN PRODUCTION
 *  *   *   *   *   *   *   *   *   *   *  *   *   *   *   *   *   *   *   *   *  *   *   *   *   *   *   *   *   *   */

namespace App\Traits;

trait Auditable
{

    public static function bootAuditable() {
        static::created(static::logFunction('created'));
        static::updated(static::logFunction('updated'));
        static::deleted(static::logFunction('deleted'));
    }

    public static function logFunction($status) {
        return function ($model) use ($status) {
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
    
                $log = new AuditLog([
                    'user_id' => $userModelRegistered ? $model->id : Auth::id(),
                    'regis_id' => !($userModelRegistered || $adminUserChanges) ? ($registrationModel ? $model->id : ($model->registration ? $model->registration->id : null)) : null,
                    'json_description' => json_encode($arr),
                    'json_ips' => json_encode(request()->ips()),
                ]);
    
                $model->AuditChanges()->save($log);
            }
        };
    }

    public function AuditChanges()
    {
        return $this->morphMany(AuditLog::class, 'auditable');
    }

}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name','label'];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class)->withTimestamps();
    }

    public function allowTo($permission)
    {
        // if we're passed a string find the permission object
        if (is_string($permission)) {
            $permission = Permission::whereName($permission)->firstOrFail();
        }
        $this->permissions()->sync($permission, false); // using sync instead of save
    }
}

<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property mixed id
 */
class User extends Authenticatable
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @var array
     */
    protected $permissions = null;

    /**
     * true if the user has all permissions
     * field is populated by the call of hasPermission()
     *
     * @var bool
     */
    protected $hasAllPermissions = false;

    /**
     * @param $permission
     *
     * @return bool
     */
    public function hasPermission($permission)
    {
        if ($this->permissions === null) {
            $this->hydratePermissions();
        }

        return $this->hasAllPermissions || in_array($permission, $this->permissions);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Hydrates permission flags
     *
     * @return void
     */
    private function hydratePermissions()
    {
        $this->permissions = [];
        $this->hasAllPermissions = false;

        /** @var Role[] $roles */
        $roles = $this->roles()->getQuery()->with('permissions')->get();

        foreach ($roles as $role) {
            if ($role->has_all_permissions) {
                $this->hasAllPermissions = true;

                return;
            }

            foreach ($role->permissions as $permission) {
                $this->permissions[] = $permission->name;
            }
        }
    }
}

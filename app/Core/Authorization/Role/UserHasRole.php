<?php


namespace App\Core\Authorization\Role;


use App\Core\Authorization\Role\Exceptions\NotHaveSuchRoleException;
use App\Core\Authorization\Role\Exceptions\RoleNotFoundException;
use App\User;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class HasRole
 * @package App\Core\Authorization\Role
 * @mixin User
 */
trait UserHasRole
{

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany|Builder|Role[]
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * @param string|Role $role
     * @return bool
     */
    public function hasRole($role)
    {
        if (is_string($role)) {
            return $this->roles()->get()->contains('name', $role);
        }

        if ($role instanceof Role) {
            return $this->roles()->get()->contains('name', $role->name);
        }

        return false;
    }


    /**
     * @param Role|string $role
     * @return $this
     * @throws RoleNotFoundException
     */
    public function assignRole($role)
    {
        if (is_string($role)) {
            $this->roles()->attach(
                Role::whereName($role)->firstOrFail()
            );
            return $this;
        }

        if ($role instanceof Role) {
            $this->roles()->save($role);
            return $this;
        }
        
        throw new RoleNotFoundException;
    }

    /**
     * @param Role|string $role
     * @return $this
     * @throws NotHaveSuchRoleException
     */
    public function removeRole($role)
    {
        if (is_string($role)) {
            $this->roles()->detach(
                Role::whereName($role)->firstOrFail()
            );
            return $this;
        }

        if ($role instanceof Role) {
            $this->roles()->detach($role);
            return $this;
        }

        throw new NotHaveSuchRoleException;
    }
}
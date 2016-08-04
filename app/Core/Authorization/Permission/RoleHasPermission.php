<?php


namespace App\Core\Authorization\Permission;


use App\Core\Authorization\Permission\Exceptions\NotHaveSuchPermissionException;
use App\Core\Authorization\Permission\Exceptions\PermissionNotFoundException;
use App\Core\Authorization\Role\Role;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class HasPermission
 * @package App\Core\Authorization\Permission
 * @mixin Role
 */
trait RoleHasPermission
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany|Builder|Permission
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    /**
     * @param string|Permission $permission
     * @return bool
     */
    public function hasPermission($permission)
    {
        if (is_string($permission)) {
            return $this->permissions()->get()->contains('name', $permission);
        }

        if ($permission instanceof Permission) {
            return $this->permissions()->get()->contains('name', $permission->name);
        }

        return false;
    }


    /**
     * @param Permission|string $permission
     * @return $this
     * @throws PermissionNotFoundException
     */
    public function assignPermission($permission)
    {
        if (is_string($permission)) {
            $this->permissions()->attach(
                Permission::whereName($permission)->firstOrFail()
            );
            return $this;
        }

        if ($permission instanceof Permission) {
            $this->permissions()->save($permission);
            return $this;
        }

        throw new PermissionNotFoundException;
    }

    /**
     * @param Permission|string $permission
     * @return $this
     * @throws NotHaveSuchPermissionException
     */
    public function removePermission($permission)
    {
        if (is_string($permission)) {
            $this->permissions()->detach(
                Permission::whereName($permission)->firstOrFail()
            );
            return $this;
        }

        if ($permission instanceof Permission) {
            $this->permissions()->detach($permission);
            return $this;
        }

        throw new NotHaveSuchPermissionException;
    }
}
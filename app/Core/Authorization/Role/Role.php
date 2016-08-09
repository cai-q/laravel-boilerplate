<?php

namespace App\Core\Authorization\Role;

use App\Core\Authorization\Permission\Permission;
use App\Core\Authorization\Permission\RoleHasPermission;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Core\Authorization\Role\Role
 *
 * @mixin \Eloquent
 * @property integer $id
 * @property string $name
 * @property string $label
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Core\Authorization\Role\Role whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Core\Authorization\Role\Role whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Core\Authorization\Role\Role whereLabel($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Core\Authorization\Role\Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Core\Authorization\Role\Role whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Core\Authorization\Permission\Permission[] $permissions
 */
class Role extends Model
{
    use RoleHasPermission;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany|Builder|User[]
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}

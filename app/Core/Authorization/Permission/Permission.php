<?php

namespace App\Core\Authorization\Permission;

use App\Core\Authorization\Role\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Core\Authorization\Permission\Permission
 *
 * @property integer $id
 * @property string $name
 * @property string $label
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Core\Authorization\Permission\Permission whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Core\Authorization\Permission\Permission whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Core\Authorization\Permission\Permission whereLabel($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Core\Authorization\Permission\Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Core\Authorization\Permission\Permission whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Core\Authorization\Role\Role[] $roles
 */
class Permission extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany|Builder|Role
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}

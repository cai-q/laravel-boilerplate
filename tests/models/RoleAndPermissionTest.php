<?php

use App\Core\Authorization\Permission\Permission;
use App\Core\Authorization\Role\Role;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RoleAndPermissionTest extends TestCase
{
    use DatabaseTransactions;

     /**
      * @test
      */
     public function roleAndPermissionGeneratedSuccessfully()
     {
         /** @var Collection $users */
         /** @var Collection $roles */
         /** @var Collection $permissions */
         list ($users, $roles, $permissions) = $this->generateTestData();

         $this->assertEquals($users->count(), 5);
         $this->assertEquals($roles->count(), 10);
         $this->assertEquals($permissions->count(), 10);
     }

     /**
      * @test
      */
     public function roleHasPermissionAndPermissionOperation()
     {
         /** @var Collection $roles */
         /** @var Collection $permissions */
         list(, $roles, $permissions) = $this->generateTestData();

         $permission = $roles->random()->permissions;
         $this->assertNotNull($permission);

         for ($i = 0; $i < 10; $i++) {
             $this->stringActionForOnce($roles, $permissions);
             $this->modelActionForOnce($roles, $permissions);
         }
     }

    /**
     * @return Collection
     */
    protected function generateFakePermissions()
    {
        return factory(Permission::class, 10)->create();
    }

    /**
     * @return Collection
     */
    protected function generateFakeRoles()
    {
        return factory(Role::class, 10)->create();
    }

    /**
     * @return Collection
     */
    protected function generateFakeUser()
    {
        return factory(User::class, 5)->create();
    }

    /**
     * @param Collection $roles
     * @param Collection $permissions
     * @param Collection $users
     */
    protected function associateThem($roles, $permissions, $users)
    {
        $roles->each(function (Role $role) use ($permissions) {
            $role->permissions()->save($permissions->random());
        });

        $users->each(function (User $user) use ($roles) {
            $user->roles()->save($roles->random());
        });
    }

    /**
     * @return array
     */
    protected function generateTestData()
    {
        $permissions = $this->generateFakePermissions();
        $roles = $this->generateFakeRoles();
        $users = $this->generateFakeUser();

        $this->associateThem($roles, $permissions, $users);

        return [$users, $roles, $permissions];
    }

    /**
     * @param Collection $roles
     * @param Collection $permissions
     */
    protected function modelActionForOnce($roles, $permissions)
    {
        /** @var Role $role */
        /** @var Permission $permission */
        $role = $roles->random();
        $permission = $permissions->random();

        if ($role->hasPermission($permission->name)) {
            $this->assertTrue($role->hasPermission($permission));
            $role->removePermission($permission);
            $this->assertFalse($role->hasPermission($permission));
        } else {
            $this->assertFalse($role->hasPermission($permission));
            $role->assignPermission($permission);
            $this->assertTrue($role->hasPermission($permission));
        }
    }

    /**
     * @param Collection $roles
     * @param Collection $permissions
     */
    protected function stringActionForOnce($roles, $permissions)
    {
        /** @var Role $role */
        /** @var Permission $permission */
        $role = $roles->random();
        $permission = $permissions->random();

        if ($role->hasPermission($permission)) {
            $this->assertTrue($role->hasPermission($permission->name));
            $role->removePermission($permission->name);
            $this->assertFalse($role->hasPermission($permission->name));
        } else {
            $this->assertFalse($role->hasPermission($permission->name));
            $role->assignPermission($permission->name);
            $this->assertTrue($role->hasPermission($permission->name));
        }
    }

}

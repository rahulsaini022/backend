<?php
  
  namespace Database\Seeders;

use App\Models\dmin;
use Illuminate\Database\Seeder;
  use App\Models\User;
  use Spatie\Permission\Models\Role;
  use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder2 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
    
        $role = Role::find(['name' => 'Admin']);
     
        $permissions = Permission::pluck('id','id')->all();
   
        $role->syncPermissions($permissions);
     
       
    }
}

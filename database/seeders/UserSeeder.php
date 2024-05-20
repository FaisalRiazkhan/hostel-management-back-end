<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //create permissions
        $user_list_menu = Permission::create(['name' => 'user_list_menu']);
        $user_create_menu = Permission::create(['name' => 'user_create_menu']);
        $user_delete_menu = Permission::create(['name' => 'user_delete_menu']);
        $user_update_menu = Permission::create(['name' => 'user_update_menu']);

        $user_list_rooms = Permission::create(['name' => 'user_list_rooms']);
        $user_create_rooms = Permission::create(['name' => 'user_create_rooms']);
        $user_update_rooms = Permission::create(['name' => 'user_update_rooms']);
        $user_delete_rooms = Permission::create(['name' => 'user_delete_rooms']);


        // create an admin user
        $admin = User::create([
            'first_name' => 'admin',
            'last_name' => 'admin',
            'national_id_no' => '142039551046',
            'phone_number' => '03124679292',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
        ]);
        // create an  admin role
        $admin_role = Role::create(['name' => 'admin']);
        // give permission to admin role where role_has_permissions
        $admin_role->givePermissionTo([
            // mess menu permission
            $user_create_menu,
            $user_list_menu,
            $user_update_menu,
            $user_delete_menu,
            // rooms permissions
            $user_list_rooms,
            $user_create_rooms,
            $user_update_rooms,
            $user_delete_rooms
        ]);

        $admin->assignRole($admin_role);

        // assign permissions directly to an admin user where model_has_permissions
        /* note we need to assign permission based on role_has_permission sor 
         we can assign permissions directly to the user based on Model_has_permissions*/

        // $admin->givePermissionTo([
        //     // mess menu permission
        //     $user_create_menu,
        //     $user_list_menu,
        //     $user_view_menu,
        //     $user_update_menu,
        //     $user_delete_menu,
        //     // rooms permissions
        //     $user_view_rooms,
        //     $user_list_rooms,
        //     $user_create_rooms,
        //     $user_update_rooms,
        //     $user_delete_rooms
        // ]);

        // now create a user user
        $user = User::create([
            'first_name' => 'user',
            'last_name' => 'user',
            'national_id_no' => '142039551046',
            'phone_number' => '03124679292',
            'email' => 'user@gmail.com',
            'password' => bcrypt('password'),
        ]);

        // create a user role
        $user_role = Role::create(['name' => 'user']);
        // give permission to user role where role_has_permissions
        $user_role->givePermissionTo([
            // mess menu permission
            $user_list_menu,
            // rooms permissions
            $user_list_rooms,
        ]);
        // assign role to the  user
        $user->assignRole($user_role);

        // assign permissions directly to  user where model_has_permissions
        /* note assign permissions directly to the user based on Model_has_permissions*/

        //   $user->givePermissionTo([
        //     // mess menu permission
        //     $user_list_menu,
        //     $user_view_menu,
        //     // rooms permissions
        //     $user_view_rooms,
        //     $user_list_rooms,
        // ]);
    }
}

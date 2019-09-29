<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('activations')->truncate();
        DB::table('users')->truncate();
        DB::table('roles')->truncate();
        DB::table('role_users')->truncate();

        $superAdminRole = [
            'name' => 'Super Admin',
            'slug' => 'super-admin',
        ];
        $superAdminRole = Sentinel::getRoleRepository()->createModel()->fill($superAdminRole)->save();

        $systemAdminRole = [
            'name' => 'Agency',
            'slug' => 'agency',
        ];
        Sentinel::getRoleRepository()->createModel()->fill($systemAdminRole)->save();

        $userRole = [
            'name' => 'User',
            'slug' => 'user',
        ];
        Sentinel::getRoleRepository()->createModel()->fill($userRole)->save();


        $admin = [
            'username' => 'admin',
            'email' => 'tungdt811@gmail.com',
            'name' => 'Admin',
            'password' => '123456789xX',
        ];
        $adminUser = Sentinel::registerAndActivate($admin);
        $adminUser->roles()->attach($superAdminRole);

        $agency = [
            'username' => 'agency',
            'email' => 'tuananhnguyen.bka@gmail.com',
            'name' => 'Agency',
            'password' => '123456789xX',
        ];

        $agencyRole = Sentinel::findRoleById(2);
        $agency = Sentinel::registerAndActivate($agency);
        $agencyRole->users()->attach($agency);

//        $user = [
//            'username' => 'user',
//            'email' => 'user@gmail.com',
//            'name' => 'User',
//            'password' => '123456',
//        ];
//
//        $userRole = Sentinel::findRoleById(3);
//        $user = Sentinel::registerAndActivate($user);
//        $userRole->users()->attach($user);

//        $tool = [
//            [
//                'name' => 'tool 1',
//                'max_point' => 1000,
//                'fee' => 1000,
//            ],
//            [
//                'name' => 'tool 2',
//                'max_point' => 2000,
//                'fee' => 2000,
//            ]
//        ];
//        \Informatics\Tool\Models\Tool::insert($tool);
    }
}

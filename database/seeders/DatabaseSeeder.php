<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Currencies;
use App\Models\Companies;
use App\Models\Branches;
use App\Models\Branch_roles;
use App\Models\Tcodes;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        //seed production
        Tcodes::insert([
            ['id' => 'users','description' => 'users','level_tcode' => '2','parent' => 'home','icon' => 'fa fa-users','url' => 'users','tcode_group' => 'users','access' => 'Public'],
            ['id' => 'users.create','description' => 'user_create','level_tcode' => '3','parent' => 'users','icon' => 'fa fa-plus','url' => 'users/create','tcode_group' => 'users','access' => 'Public'],
            ['id' => 'users.edit','description' => 'user_edit','level_tcode' => '3','parent' => 'users','icon' => 'fa fa-edit','url' => 'users/edit','tcode_group' => 'users','access' => 'Public'],
            ['id' => 'users.reset','description' => 'users_reset','level_tcode' => '3','parent' => 'users','icon' => 'fa fa-key','url' => 'users/reset','tcode_group' => 'users','access' => 'Public'],
            ['id' => 'users.branch_roles','description' => 'branch_user_roles','level_tcode' => '3','parent' => 'users','icon' => 'fa fa-universal-access','url' => 'users/branch_roles','tcode_group' => 'users','access' => 'Public'],
            ['id' => 'roles','description' => 'roles','level_tcode' => '2','parent' => 'home','icon' => 'fa fa-universal-access','url' => 'roles','tcode_group' => 'roles','access' => 'Public'],
            ['id' => 'roles.create','description' => 'role_create','level_tcode' => '3','parent' => 'roles','icon' => 'fa fa-plus','url' => 'roles/create','tcode_group' => 'roles','access' => 'Public'],
            ['id' => 'roles.show','description' => 'role_show','level_tcode' => '3','parent' => 'roles','icon' => 'fa fa-folder-open','url' => 'roles/show','tcode_group' => 'roles','access' => 'Public'],
            ['id' => 'roles.delete','description' => 'role_delete','level_tcode' => '3','parent' => 'roles','icon' => 'fa fa-times','url' => 'roles/delete','tcode_group' => 'roles','access' => 'Public'],
            ['id' => 'branches','description' => 'branches','level_tcode' => '2','parent' => 'home','icon' => 'fa fa-code-branch','url' => 'branches','tcode_group' => 'branches','access' => 'Public'],
            ['id' => 'branches.create','description' => 'branch_create','level_tcode' => '3','parent' => 'branches','icon' => 'fa fa-plus','url' => 'branches/create','tcode_group' => 'branches','access' => 'Public'],
            ['id' => 'branches.edit','description' => 'branch_edit','level_tcode' => '3','parent' => 'branches','icon' => 'fa fa-edit','url' => 'branches/edit','tcode_group' => 'branches','access' => 'Public'],
            
        ]);
        
        Currencies::create([
            'id'            => 'IDR',
            'description'   => 'Indonesia Rupiah',
        ]);


        //seed dev
        User::create([
            'id'            => 'demo',
            'name'          => 'Hastio Apps',
            'email'         => 'hastio.apps@gmail.com',
            'phone'         => '085268952644', 
            'password'      => Hash::make('Allahu4kbar'),
            'role_id'       => 'Admin',
            'status'        => 'Enabled',
            'started'         => 'Welcome',
            'master'        => true,
            'email_verified_at'=>now(),
            'company_id'       => 'demo',
        ]);

        Companies::create([
            'id'            => 'demo',
            'name'          => 'Hastio Apps',
            'address'       => 'Palembang',
            'currency_id'   => 'IDR', 
            'email'         => 'hastio.apps@gmail.com',
            'phone'         => '085268952644',  
            'owner'         => 'Hastio Pipandani, S.E.,M.M.',
        ]);

        Branches::create([
            'id'            => 'demoHO',
            'code'          => 'HO',
            'name'          => 'Head Office',
            'address'       => 'Palembang',
            'email'         => 'hastio.apps@gmail.com',
            'phone'         => '085268952644',  
            'manager'       => 'Hastio Pipandani, S.E.,M.M.',
            'company_id'    => 'demo',
        ]);
        
        Branch_roles::create([
            'id'            => 'demoHOdemo',
            'user_id'       => 'demo',
            'branch_id'     => 'demoHO',
        ]);
    }
}

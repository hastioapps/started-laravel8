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

        //seed default
        Tcodes::insert([
            /*['id' => 'A000','description' => 'journal_entries','level_tcode' => '1','parent' => '0000','icon' => 'fa fa-book','url' => 'journal_entries','tcode_group_id' => '0','access' => 'Public'],
            ['id' => 'A010','description' => 'general_journals','level_tcode' => '2','parent' => 'A000','icon' => 'fa fa-newspaper','url' => 'journal_entries/general','tcode_group_id' => 'A010','access' => 'Public'],
            ['id' => 'A011','description' => 'add_general_journals','level_tcode' => '3','parent' => 'A010','icon' => 'fa fa-plus','url' => 'journal_entries/general/add','tcode_group_id' => 'A010','access' => 'Public'],
            ['id' => 'A020','description' => 'cash_bank','level_tcode' => '2','parent' => 'A000','icon' => 'fa fa-money-bill-alt','url' => 'journal_entries/cash_bank','tcode_group_id' => 'A020','access' => 'Public'],
            ['id' => 'A021','description' => 'cash_receipts','level_tcode' => '3','parent' => 'A020','icon' => 'fa fa-plus','url' => 'journal_entries/cash_bank/cash_receipts','tcode_group_id' => 'A020','access' => 'Public'],
            ['id' => 'A022','description' => 'cash_disbursement','level_tcode' => '3','parent' => 'A020','icon' => 'fa fa-plus','url' => 'journal_entries/cash_bank/cash_disbursement','tcode_group_id' => 'A020','access' => 'Public'],
            ['id' => 'A023','description' => 'fund_transfer','level_tcode' => '3','parent' => 'A020','icon' => 'fa fa-plus','url' => 'journal_entries/cash_bank/fund_transfer','tcode_group_id' => 'A020','access' => 'Public'],
            ['id' => 'A030','description' => 'reverse_journals','level_tcode' => '2','parent' => 'A000','icon' => 'fa fa-shekel-sign','url' => 'journal_entries/reverse','tcode_group_id' => 'A010','access' => 'Public'],
            ['id' => 'A040','description' => 'searching_journals','level_tcode' => '2','parent' => 'A000','icon' => 'fa fa-search','url' => 'journal_entries/searching','tcode_group_id' => 'A010','access' => 'Public'],
            ['id' => 'A050','description' => 'edit_journal','level_tcode' => '2','parent' => 'A000','icon' => 'fa fa-edit','url' => 'journal_entries/edit','tcode_group_id' => 'A010','access' => 'Public'],
            ['id' => 'X000','description' => 'reports','level_tcode' => '1','parent' => '0000','icon' => 'fa fa-file','url' => 'reports','tcode_group_id' => '0','access' => 'Public'],
            ['id' => 'X011','description' => 'general_ledger','level_tcode' => '2','parent' => 'X010','icon' => 'fa fa-book','url' => 'reports/general_ledger','tcode_group_id' => 'X010','access' => 'Public'],
            ['id' => 'X012','description' => 'profit_or_loss','level_tcode' => '2','parent' => 'X010','icon' => 'fa fa-book','url' => 'reports/profit_or_loss','tcode_group_id' => 'X010','access' => 'Public'],
            ['id' => 'X013','description' => 'financial_position','level_tcode' => '2','parent' => 'X010','icon' => 'fa fa-book','url' => 'reports/financial_position','tcode_group_id' => 'X010','access' => 'Public'],
            ['id' => 'X014','description' => 'trial_balance','level_tcode' => '2','parent' => 'X010','icon' => 'fa fa-book','url' => 'reports/trial_balance','tcode_group_id' => 'X010','access' => 'Public'],
            ['id' => 'Y000','description' => 'master_data','level_tcode' => '1','parent' => '0000','icon' => 'fa fa-cog','url' => 'master','tcode_group_id' => '0','access' => 'Public'],
            ['id' => 'Y010','description' => 'account','level_tcode' => '2','parent' => 'Y000','icon' => 'fa fa-list-ol','url' => 'master/account','tcode_group_id' => 'Y010','access' => 'Public'],
            ['id' => 'Y011','description' => 'add_account','level_tcode' => '3','parent' => 'Y010','icon' => 'fa fa-plus','url' => 'master/account/add','tcode_group_id' => 'Y010','access' => 'Public'],
            ['id' => 'Y012','description' => 'edit_account','level_tcode' => '3','parent' => 'Y010','icon' => 'fa fa-edit','url' => 'master/account/edit','tcode_group_id' => 'Y010','access' => 'Public'],
            ['id' => 'Z030','description' => 'operating_segment','level_tcode' => '2','parent' => 'Z000','icon' => 'fa fa-crosshairs','url' => 'setting/segment','tcode_group_id' => 'Z000','access' => 'Public'],
            ['id' => 'Z080','description' => 'linked_account','level_tcode' => '2','parent' => 'Z000','icon' => 'fa fa-link','url' => 'setting/linked_account','tcode_group_id' => 'Z000','access' => 'Public'],
            ['id' => 'Z090','description' => 'period','level_tcode' => '2','parent' => 'Z000','icon' => 'fa fa-clock','url' => 'setting/period','tcode_group_id' => 'Z000','access' => 'Public'],
            */
            ['id' => 'USER','description' => 'users','level_tcode' => '2','parent' => '0000','icon' => 'fa fa-users','url' => 'users','tcode_group_id' => '0','access' => 'Public'],
            ['id' => 'USRC','description' => 'users_create','level_tcode' => '3','parent' => 'USER','icon' => 'fa fa-plus','url' => 'users/create','tcode_group_id' => 'USER','access' => 'Public'],
            ['id' => 'ROLE','description' => 'roles','level_tcode' => '2','parent' => '0000','icon' => 'fa fa-universal-access','url' => 'roles','tcode_group_id' => '0','access' => 'Public'],
            ['id' => 'ROLC','description' => 'roles_create','level_tcode' => '3','parent' => 'ROLE','icon' => 'fa fa-plus','url' => 'roles/create','tcode_group_id' => 'ROLE','access' => 'Public'],
            ['id' => 'Z010','description' => 'branch','level_tcode' => '2','parent' => 'Z000','icon' => 'fa fa-rss','url' => 'setting/branch','tcode_group_id' => 'Z010','access' => 'Public'],
            ['id' => 'Z011','description' => 'add_branch','level_tcode' => '3','parent' => 'Z010','icon' => 'fa fa-plus','url' => 'setting/branch/add','tcode_group_id' => 'Z010','access' => 'Public'],
            ['id' => 'Z012','description' => 'edit_branch','level_tcode' => '3','parent' => 'Z010','icon' => 'fa fa-edit','url' => 'setting/branch/edit','tcode_group_id' => 'Z010','access' => 'Public'],
        ]);
        
        Currencies::create([
            'id'            => 'IDR',
            'description'   => 'Indonesia Rupiah',
        ]);


        //seed default
        User::create([
            'id'            => 1,
            'username'      => 'hastioapps',
            'name'          => 'Hastio Apps',
            'email'         => 'hastio.apps@gmail.com',
            'phone'         => '085268952644', 
            'password'      => Hash::make('Allahu4kbar'),
            'role_id'       => 'Admin',
            'status'        => 'Enabled',
            'started'         => 'Welcome',
            'master'        => true,
            'email_verified_at'=>now(),
            'company_id'       => 1,
        ]);

        Companies::create([
            'id'            => 1,
            'name'          => 'Hastio Apps',
            'address'       => 'Palembang',
            'currency_id'   => 'IDR', 
            'email'         => 'hastio.apps@gmail.com',
            'phone'         => '085268952644',  
            'owner'         => 'Hastio Pipandani, S.E.,M.M.',
        ]);

        Branches::create([
            'id'            => '1HO',
            'code'          => 'HO',
            'name'          => 'Head Office',
            'address'       => 'Palembang',
            'email'         => 'hastio.apps@gmail.com',
            'phone'         => '085268952644',  
            'manager'       => 'Hastio Pipandani, S.E.,M.M.',
            'company_id'    => 1,
        ]);
        
        Branch_roles::create([
            'id'            => '1HO1',
            'user_id'       => 1,
            'branch_id'     => '1HO',
        ]);
    }
}

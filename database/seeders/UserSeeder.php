<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $google2fa = app('pragmarx.google2fa');
        if(isAddonInstalled('DESKSAAS') > 0){
            User::insert([
                ['uuid' => '12345', 'name' => 'Super Admin Doe', 'role' => USER_ROLE_SUPER_ADMIN, 'email' => 'sadmin@gmail.com', 'password' => Hash::make(123456), 'status' => USER_STATUS_ACTIVE, 'google2fa_secret' => ''],
                ['uuid' => '123456', 'name' => 'Admin Doe', 'role' => USER_ROLE_ADMIN, 'email' => 'admin@gmail.com', 'password' => Hash::make(123456), 'status' => USER_STATUS_ACTIVE, 'google2fa_secret' => ''],
            ]);
        }else{
            User::insert([
                ['uuid' => '12345', 'name' => 'Admin Doe', 'role' => USER_ROLE_SUPER_ADMIN, 'email' => 'admin@gmail.com', 'password' => Hash::make(123456), 'status' => USER_STATUS_ACTIVE, 'google2fa_secret' => ''],
            ]);
            $random = 'zainiklab';
            $central_domains = env('APP_URL');
            $central_domains = parse_url($central_domains, PHP_URL_HOST);
            $tenant = Tenant::create(['id' => $random]);
            $tenant->domains()->create(['domain' => $central_domains,'user_domain' => $central_domains]);
            $userDataUpdate = User::where('id', 1)->first();
            $userDataUpdate->tenant_id = $random;
            $userDataUpdate->save();
        }

    }
}

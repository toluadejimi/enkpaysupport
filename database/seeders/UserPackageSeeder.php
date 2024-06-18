<?php

namespace Database\Seeders;

use App\Models\Package;
use App\Models\SubCategory;
use App\Models\User;
use App\Models\UserPackage;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UserPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $users = User::where(['role' => USER_ROLE_ADMIN])->get();
        $defaultPackage = Package::where(['is_trail' => ACTIVE])->first();
        foreach($users as $user){
            setUserPackage($user->id, $defaultPackage, (int)getOption('trail_duration', 1));
        }
    }
}

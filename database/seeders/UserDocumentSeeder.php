<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserDocument;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserDocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserDocument::insert([
            ['user_id' => '2','passport_image' => 1,'driver_front_image' => null ,'driver_back_image' => null],
            ['user_id' => '2','passport_image' => null,'driver_front_image' => 1 ,'driver_back_image' => 1],
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Gateway;
use App\Models\KYCGateway;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KYCGatewaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'Driving Verification', 'type' => 'Driver License', 'status' => ACTIVE],
            ['name' => 'Email Verification', 'type' => 'Email', 'status' => ACTIVE],
            ['name' => 'NID Verification', 'type' => 'National ID', 'status' => ACTIVE],
            ['name' => 'Passport Verification', 'type' => 'Passport', 'status' => ACTIVE],
            ['name' => 'Phone Verification', 'type' => 'Phone Number', 'status' => ACTIVE],
            ['name' => 'Voter Card Verification', 'type' => 'Voter Card', 'status' => ACTIVE],
        ];
        KYCGateway::insert($data);
    }
}

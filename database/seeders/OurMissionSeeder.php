<?php

namespace Database\Seeders;

use App\Models\HowItWork;
use App\Models\OurMission;
use Illuminate\Database\Seeder;

class OurMissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OurMission::create([
            'title' => 'The Zaidesk platform is the Most Probable solution.',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco ex ea commodo consequat. Duis aute irure dolor',
            'description_point' => [
                'Diam dictumst faucibus dui aliquet aenean nascetur feugiat leo Etiam',
                'Blandit dignissim nulla varius tristique a sed integer ut tempor Diam dictumst',
                'Esd nam vulputate pellentesque quis. Varius a, nunc faucibus proin elementum',
                'Nteger interdum sodales scelerisque diam massa quam sit quis. Sed et du'
            ],
            'image' => '/frontend/assets/images/mission-image.jpg',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }


}

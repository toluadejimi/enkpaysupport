<?php

namespace Database\Seeders;

use App\Models\FrontendSection;
use Illuminate\Database\Seeder;

class FrontendSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(getOption('ZAIDESKTENANCY_build_version') !=null && getOption('ZAIDESKTENANCY_build_version') > 0){
            FrontendSection::create(['created_by'=>1, 'name' => 'Hero Banner', 'title' => 'Zaidesk Simple & Secure Way to Enter your Mining.', 'slug' => 'hero_banner', 'has_image' => STATUS_ACTIVE, 'description' => 'Zaidesk is a cryptocurrency mining application designed to be a highly secure platform design for future miners. Start mining and achieve the highest level of Hashrate.', 'image' => NULL, 'status' => STATUS_ACTIVE, 'created_at' => now(), 'updated_at' => now()]);
            FrontendSection::create(['created_by'=>1, 'name' => 'Features Area', 'title' => 'All The logical_reason You Will Get', 'slug' => 'features_area' , 'has_image' => STATUS_PENDING, 'description' => 'Nisl diam sodales lacus laoreet commodo congue. maece blandit montes lobort parturient..', 'image' => NULL , 'status' => STATUS_ACTIVE, 'created_at' => now()]);
            FrontendSection::create(['created_by'=>1, 'name' => 'Price Area', 'title' => 'Pricing that suits your needs', 'slug' => 'price_area' , 'has_image' => STATUS_PENDING, 'description' => 'Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id maxime placeat facere possimus.', 'image' => NULL , 'status' => STATUS_ACTIVE, 'created_at' => now()]);
            FrontendSection::create(['created_by'=>1, 'name' => 'Testimonial Area', 'title' => 'Hear what our users have said about Zaidesk.', 'slug' => 'testimonial_area' , 'has_image' => STATUS_PENDING, 'description' => 'Praesent consectetur iaculis et, malesuada facilisi. Suspendisse pretium quis pulvinar tempor commodo, eget tellus morbi. Morbi netus', 'image' => NULL , 'status' => STATUS_ACTIVE, 'created_at' => now()]);
            FrontendSection::create(['created_by'=>1, 'name' => 'Faq Area', 'title' => 'Frequently Asked Questions', 'slug' => 'faq_area' , 'has_image' => STATUS_PENDING, 'description' => 'Praesent consectetur iacul vitae, malesua facilisi. Suspendisse pretium quis pulvinar tempor commodo, at eget tellus morbi.', 'image' => NULL , 'status' => STATUS_ACTIVE, 'created_at' => now()]);

        }else{
            $frontendSectionData = [
                ['created_by'=>1, 'name' => 'Hero Banner', 'title' => 'Zaidesk Simple & Secure Way to Enter your Mining.', 'slug' => 'hero_banner', 'has_image' => STATUS_ACTIVE, 'description' => 'Zaidesk is a cryptocurrency mining application designed to be a highly secure platform design for future miners. Start mining and achieve the highest level of Hashrate.', 'image' => NULL, 'status' => STATUS_ACTIVE, 'created_at' => now(), 'updated_at' => now()],
                ['created_by'=>1,'name' => 'Features Area', 'title' => 'All The logical_reason You Will Get', 'slug' => 'features_area' , 'has_image' => STATUS_PENDING, 'description' => 'Nisl diam sodales lacus laoreet commodo congue. maece blandit montes lobort parturient..', 'image' => NULL , 'status' => STATUS_ACTIVE, 'created_at' => now()],
                ['created_by'=>1,'name' => 'Price Area', 'title' => 'Pricing that suits your needs', 'slug' => 'price_area' , 'has_image' => STATUS_PENDING, 'description' => 'Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id maxime placeat facere possimus.', 'image' => NULL , 'status' => STATUS_ACTIVE, 'created_at' => now()],
                ['created_by'=>1,'name' => 'Testimonial Area', 'title' => 'Hear what our users have said about Zaidesk.', 'slug' => 'testimonial_area' , 'has_image' => STATUS_PENDING, 'description' => 'Praesent consectetur iaculis et, malesuada facilisi. Suspendisse pretium quis pulvinar tempor commodo, eget tellus morbi. Morbi netus', 'image' => NULL , 'status' => STATUS_ACTIVE, 'created_at' => now()],
                ['created_by'=>1,'name' => 'Faq Area', 'title' => 'Frequently Asked Questions', 'slug' => 'faq_area' , 'has_image' => STATUS_PENDING, 'description' => 'Praesent consectetur iacul vitae, malesua facilisi. Suspendisse pretium quis pulvinar tempor commodo, at eget tellus morbi.', 'image' => NULL , 'status' => STATUS_ACTIVE, 'created_at' => now()],
                ['created_by'=>1,'name' => 'Faq Mood Area', 'title' => 'Frequently asked questions', 'slug' => 'faq_mood_area' , 'has_image' => STATUS_PENDING, 'description' => 'Get answers to commonly asked questions and find solutions to your queries in our comprehensive faq section', 'image' => NULL , 'status' => STATUS_ACTIVE, 'created_at' => now()],
                ['created_by'=>1,'name' => 'knowledge Area', 'title' => 'knowledge Area', 'slug' => 'knowledge_area' , 'has_image' => STATUS_PENDING, 'description' => 'knowledge area Get answers to commonly asked questions and find solutions to your queries in our comprehensive faq section', 'image' => NULL , 'status' => STATUS_ACTIVE, 'created_at' => now()],
                ['created_by'=>1,'name' => 'Need Support Area', 'title' => 'Need Support & Response within 24 hours?', 'slug' => 'need_support_area' , 'has_image' => STATUS_PENDING, 'description' => 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam quae ab illo inventore.', 'image' => NULL , 'status' => STATUS_ACTIVE, 'created_at' => now()],
                ['created_by'=>1,'name' => 'Looking Support Area', 'title' => 'Looking For Support?', 'slug' => 'looking_support_area' , 'has_image' => STATUS_PENDING, 'description' => "Can't find the answer you're looking for? Don't worry we're here to solve your problem!", 'image' => NULL , 'status' => STATUS_ACTIVE, 'created_at' => now()],
            ];
            foreach ($frontendSectionData as $item){
                FrontendSection::create($item);
            }
        }


    }
}

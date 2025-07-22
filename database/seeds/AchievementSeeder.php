<?php

use Illuminate\Database\Seeder;
use App\Achievement;

class AchievementSeeder extends Seeder
{
    public function run()
    {
        $achievements = [
            [
                'name' => 'First Post',
                'description' => 'Made your first post!',
                'icon' => 'icons/first_post.svg',
                'type' => 'post',
                'requirement' => 1,
            ],
            [
                'name' => 'Photographer Gamer',
                'description' => 'Posted 5 pictures!',
                'icon' => 'icons/photographer.svg',
                'type' => 'post',
                'requirement' => 5,
            ],
             [
                'name' => 'Getting The Hang Of It',
                'description' => 'Posted 10 pictures!',
                'icon' => 'icons/photographer10.svg',
                'type' => 'post',
                'requirement' => 10,
            ],
        ];

        foreach ($achievements as $data) {
            if (!Achievement::where('name', '=', $data['name'])->exists()) {
                Achievement::create($data);
            }
        }
    }
}

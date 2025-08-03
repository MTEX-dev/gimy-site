<?php

namespace Database\Seeders;

use App\Models\Site;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::first();

        if ($user) {
            Site::create([
                'user_id' => $user->id,
                'name' => 'My First Site',
                'description' => 'This is my first site created with gimy.site.',
            ]);
        }
    }
}

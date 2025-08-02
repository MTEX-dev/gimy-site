<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\Site;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class SiteFileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        /*
        $site_id = Site::inRandomOrder()->first()->id
        return [
            'site_id' => $site_id,
            'path' => $site_id/,
            'email_verified_at' => now(),
            'password' => Hash::make('Password'),
            'remember_token' => Str::random(10),
        ];
        */
    }
}

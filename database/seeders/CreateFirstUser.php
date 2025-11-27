<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
class CreateFirstUser extends Seeder
{
    /**
     * Run the database seeds.
     */
       public function run(): void
    {
        for ($i = 0; $i < 20; $i++) {

            // Ambil gambar random dari internet
            $img = Http::get("https://picsum.photos/300")->body();
            $filename = 'profile-' . uniqid() . '.jpg';

            Storage::put('public/profiles/' . $filename, $img);

            User::create([
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'password' => bcrypt('password'),
                'profile_picture' => $filename,
            ]);
        }
    }


}

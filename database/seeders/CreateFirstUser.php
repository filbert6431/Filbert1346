<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

use App\Models\User;
class CreateFirstUser extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void
{
    Storage::makeDirectory('public/profiles');

    for ($i = 0; $i < 20; $i++) {

        // Generate fake image
        $fakeImage = UploadedFile::fake()->image('profile.jpg', 300, 300);

        // Simpan ke folder storage
        $path = $fakeImage->store('public/profiles');

        // Ambil nama file saja
        $filename = str_replace('public/profiles/', '', $path);

        User::create([
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => bcrypt('password'),
            'profile_picture' => $filename,
        ]);
    }
}


}

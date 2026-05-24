<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Manggil UserSeeder lu yang cakep tadi
        $this->call([
            UserSeeder::class,
        ]);
    }
}
<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserTableSeeder::class);
        $this->call(CategoryTableSeeder::class);
        $this->call(ProductTableSeeder::class);
        $this->call(ProductInputTableSeeder::class);
        $this->call(ProductOutputTableSeeder::class);
        $this->call(ProductPhotosTableSeeder::class);
    }
}

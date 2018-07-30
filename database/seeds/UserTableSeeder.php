<?php

use Illuminate\Database\Seeder;
use CodeShopping\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class)->create([
            'email' => 'admin@user.com'
        ]);
        
        factory(User::class, 50)->create();
    }
}

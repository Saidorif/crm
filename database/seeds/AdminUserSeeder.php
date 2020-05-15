<?php

use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Saidorif Kadirov',
            'email' => 'sayyid2112@gmail.com',
            'password' => Hash::make('123456'),
            'role_id' => 1,
            'gender' => 'male',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $supervisors = User::factory(3)->create();
        
        foreach ($supervisors as $supervisor) {
         $supervisor->assignRole('Supervisor');
        };

        User::create([
            'name' => 'Nabil Jara',
            'email' => 'nabiljara26@gmail.com',
            'dni' => 38798369,
            'phone_number' => 2974714701,
            'password' => bcrypt('1234'),
        ])->assignRole('Administrador')->assignRole('Contador')->assignRole('Supervisor');

        User::create([
            'name' => 'Facundo Vidili',
            'email' => 'facu_vidili@gmail.com',
            'dni' => 25919349,
            'phone_number' => 2974563245,
            'password' => bcrypt('1234'),
        ])->assignRole('Supervisor');;
        User::create([
            'name' => 'Tomas Caniza',
            'email' => 'tomi_caniza@gmail.com',
            'dni' => 50123030,
            'phone_number' => 2974234544,
            'password' => bcrypt('1234'),
        ])->assignRole('Contador');;
        User::create([
            'name' => 'Martín Alvarez',
            'email' => 'martin@gmail.com',
            'dni' => 42339233,
            'phone_number' => 2974123555,
            'password' => bcrypt('1234'),
        ])->assignRole('Contador');;
    }
}

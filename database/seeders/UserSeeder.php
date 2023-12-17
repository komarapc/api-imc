<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Hidehalo\Nanoid\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $client = new Client();
        $roles = Role::get()->first();
        $users = [
            [
                'id' => $client->generateId(21),
                'name' => 'Developer',
                'email' => 'developer@mail.com',
                'password' => Hash::make('rememberPassword123'),
                'role_id' => $roles->id,
            ],
            [
                'id' => $client->generateId(21),
                'name' => 'Admin imc',
                'email' => 'adminimc@mail.com',
                'password' => Hash::make('rememberPassword123'),
                'role_id' => $roles->id,
            ],
        ];
        User::insert($users);
    }
}

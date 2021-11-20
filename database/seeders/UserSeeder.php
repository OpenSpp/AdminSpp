<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arrayData = [
            [
                'name' => 'Super Admin',
                'email' => 'super@admin.com',
                'password' => Hash::make("12345678"),
                'role' => "super-admin"
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make("12345678"),
                'role' => "admin"
            ]
        ];
        
        foreach($arrayData as $key => $value) {
            User::create($value);
        }
    }
}

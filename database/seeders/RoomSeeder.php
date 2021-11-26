<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomSeeder extends Seeder
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
                'name' => '2020-2021',
                'price' => 50000,
                're_registration' => 150000,
                'description' => 'SPP dan Daftar Ulang Angkatan 2020-2021',
            ]
        ];

        foreach($arrayData as $value) {
            Room::create($value);
        }
    }
}

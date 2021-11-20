<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
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
                'name' => 'Administrasi',
                'queue_code' => 'A',
                'services_per_day' => 20,
                'service' => [
                    ['name' => 'PEMBAYARAN SPP'],
                    ['name' => 'PEMBAYARAN DAFTAR ULANG'],
                ]
            ],
        ];
        
        foreach($arrayData as $key => $value) {
            $service = $value['service'];
            unset($value['service']);
            if($model =  Department::create($value)) {
                $model->createService($service);
            }
        }
    }
}

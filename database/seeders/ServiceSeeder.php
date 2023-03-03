<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;
use Illuminate\Support\Facades\Schema;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */


    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Service::truncate();
        Schema::enableForeignKeyConstraints();

        $services = [
            [
                'name' => 'Intrattenimento', 
                'icon' => '<i class="fa-solid fa-children"></i>'

            ],
            [
                'name' => 'Doccia', 
                'icon' => '<i class="fa-solid fa-shower"></i>'
            ],
            [
                'name' => 'Idromassaggio', 
                'icon' => '<i class="fa-solid fa-bath"></i>'
            ],
            [
                'name' => 'Zonarelax', 
                'icon' => '<i class="fa-solid fa-spray-can-sparkles"></i>'
            ],
            [
                'name' => 'Cancellazione', 
                'icon' => '<i class="fa-regular fa-calendar-xmark"></i>'
            ], 
            [
                'name' => 'Animali', 
                'icon' => '<i class="fa-solid fa-paw"></i>'
            ],
            [
                'name' => 'Parcheggio', 
                'icon' => '<i class="fa-solid fa-square-parking"></i>'
            ], 
            [
                'name' => 'Navetta', 
                'icon' => '<i class="fa-solid fa-van-shuttle"></i>'
                
            ],
            [
                'name' => 'TV', 
                'icon' => '<i class="fa-solid fa-tv"></i>'
            ],
            [
                'name' => 'Climatizato', 
                'icon' => '<i class="fa-regular fa-snowflake"></i>'
            ],
            [
                'name' => 'Wifi', 
                'icon' => '<i class="fa-solid fa-wifi"></i>'
            ],
            [
                'name' => 'Fumatori', 
                'icon' => '<i class="fa-solid fa-smoking"></i>'
            ]
        ];

        foreach ($services as $service) {
            $new_service = new Service();
            $new_service->name = $service['name'];
            $new_service->icon = $service['icon'];
            $new_service->save();
        }
    }
}

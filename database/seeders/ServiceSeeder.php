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
            'Wifi',
            'Vasca',
            'Vasca idromassaggio',
            'Spa zonarelax',
            'Cancellazione gratuita', 
            'Animali ammessi',
            'Parcheggio gratuito', 
            'Area intrattenimento bimbi',
            'TV',
            'Stanza climatizzata',
            'Servizio navetta',
            'Zona fumatori',
        ];

        foreach ($services as $service) {
            $new_service = new Service();
            $new_service->name = $service;
            $new_service->save();
        }
    }
}

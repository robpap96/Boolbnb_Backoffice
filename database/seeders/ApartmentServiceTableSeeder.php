<?php

namespace Database\Seeders;

use App\Models\Apartment;
use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class ApartmentServiceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $apartments = Apartment::all();

        // Seeding apartments with at least one service
        foreach ($apartments as $apartment) {
            $random_service = Service::inRandomOrder()->first(); // Get a random (full) record from user Model
            $apartment->services()->sync($random_service->id);
        }
    }
}

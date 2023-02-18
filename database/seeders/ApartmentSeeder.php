<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Apartment;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;

class ApartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        Schema::disableForeignKeyConstraints();
        Apartment::truncate();
        Schema::enableForeignKeyConstraints();

        for ($i=0; $i < 10; $i++) {
            $new_apartment = new Apartment();
            $new_apartment->user_id = 1;
            $new_apartment->title = $faker->sentence(4, true);
            $new_apartment->rooms_num = $faker->numberBetween(3,15);
            $new_apartment->beds_num = ceil($new_apartment->rooms_num / 2);
            $new_apartment->baths_num = ceil($new_apartment->rooms_num / 3);
            $new_apartment->description = $faker->paragraph(50);
            $new_apartment->price = $faker->randomFloat(2,35,10000);
            $new_apartment->mq = ($new_apartment->rooms_num * rand(8, 20));
            $new_apartment->image = $faker->imageUrl(640, 480, 'home', true);
            
            do {
                $new_apartment->latitude = $faker->latitude(35, 47);
                $new_apartment->longitude = $faker->longitude(6, 18);

                // TomTom finds addresses from latitude and longitude
                $getAddressFromCoords = Http::get("https://api.tomtom.com/search/2/reverseGeocode/crossStreet/{$new_apartment->latitude},{$new_apartment->longitude}.json?key=S7Di8WQbB2pqxqTH8RYmhO63cZwgtNgp&limit=1&radius=20000&language=NGT&allowFreeformNewline=false&view=Unified");
                $answer = $getAddressFromCoords->json();
            } while ($answer['summary']['numResults'] === 0);

            $address = $answer['addresses'][0]['address'];
            $new_apartment->full_address = "{$address['freeformAddress']}, {$address['countrySubdivision']}, {$address['country']}";

            $new_apartment->is_visible = $faker->boolean();
            $new_apartment->save();
        }
    }
}

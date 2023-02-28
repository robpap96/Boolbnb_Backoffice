<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Apartment;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
use illuminate\Support\Str;

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

        $home_images = [
            'https://static9.depositphotos.com/1086013/1149/i/450/depositphotos_11497591-stock-photo-superb-backyard.jpg',
            'https://st2.depositphotos.com/1370441/7847/i/450/depositphotos_78479540-stock-photo-luxury-home-with-pool-at.jpg',
            'https://st.depositphotos.com/1053646/4438/i/450/depositphotos_44386219-stock-photo-luxury-beach-resort.jpg',
            'https://static5.depositphotos.com/1040082/460/i/450/depositphotos_4601928-stock-photo-luxury-tropical-villa-garden-swimming.jpg',
            'https://static6.depositphotos.com/1005018/596/i/600/depositphotos_5961491-stock-photo-outdooroutdoor.jpg',
            'https://st.depositphotos.com/1017187/3043/i/450/depositphotos_30430657-stock-photo-luxury-home-with-a-garden.jpg',
            'https://st2.depositphotos.com/1370441/7847/i/450/depositphotos_78479454-stock-photo-luxury-home-with-pool-at.jpg',
            'https://st2.depositphotos.com/1247468/6774/i/450/depositphotos_67746161-stock-photo-modern-home-at-dusk.jpg',
            'https://st.depositphotos.com/2018053/2924/i/450/depositphotos_29246729-stock-photo-modern-villa-by-night.jpg',
            'https://st2.depositphotos.com/1672917/6935/i/450/depositphotos_69353471-stock-photo-outdoor-interior-of-modern-house.jpg'
        ];

        for ($i=0; $i < 10; $i++) {
            $new_apartment = new Apartment();
            $random_user = User::inRandomOrder()->first();
            $new_apartment->user_id = $random_user->id;
            $new_apartment->title = $faker->sentence(4, true);
            $new_apartment->rooms_num = $faker->numberBetween(3,15);
            $new_apartment->beds_num = ceil($new_apartment->rooms_num / 2);
            $new_apartment->baths_num = ceil($new_apartment->rooms_num / 3);
            $new_apartment->description = $faker->paragraph(50);
            $new_apartment->price = $faker->randomFloat(2,35,10000);
            $new_apartment->mq = ($new_apartment->rooms_num * rand(8, 20));
            $new_apartment->image = $home_images[$i];
            
            do {
                $new_apartment->latitude = $faker->latitude(35, 47);
                $new_apartment->longitude = $faker->longitude(6, 18);

                // TomTom finds addresses from latitude and longitude
                $getAddressFromCoords = Http::get("https://api.tomtom.com/search/2/reverseGeocode/crossStreet/{$new_apartment->latitude},{$new_apartment->longitude}.json?key=S7Di8WQbB2pqxqTH8RYmhO63cZwgtNgp&limit=1&radius=20000&language=NGT&allowFreeformNewline=false&view=Unified");
                $answer = $getAddressFromCoords->json();
            } while ($answer['summary']['numResults'] === 0);

            $address = $answer['addresses'][0]['address'];
            $new_apartment->full_address = $address['freeformAddress'] . ', ' . (array_key_exists('countrySubdivision', $address) ? $address['countrySubdivision'] : '') .  ', ' . $address['country'];

            $new_apartment->is_visible = $faker->boolean();

            $slug = Str::slug($new_apartment->title, '-') . '-' . Str::slug($new_apartment->full_address, '-') . '-' . Str::slug($new_apartment->user_id, '-') . '-' . $new_apartment->getNextId();
            $new_apartment->slug = $slug;
            $new_apartment->save();
        }
    }
}

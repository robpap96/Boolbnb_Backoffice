<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Apartment;
use Faker\Generator as Faker;
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

       $apartments = config('apartments');
       foreach ($apartments as $apartment) {
            $new_apartment = new Apartment();
            $new_apartment->user_id = $apartment['user_id'];
            $new_apartment->title = $apartment['title'];
            $new_apartment->rooms_num = $faker->numberBetween(1,15);
            $new_apartment->beds_num = ceil($new_apartment->rooms_num/2);
            $new_apartment->baths_num = $faker->numberBetween(1,5);
            $new_apartment->description = $faker->paragraph(800);
            $new_apartment->price = $faker->randomFloat(2,35,10000);
            $new_apartment->mq = $faker->numberBetween(40,500);
            $new_apartment->image = $faker->imageUrl(null,400,400);
            $new_apartment->full_address = $apartment['full_address'];
            $new_apartment->latitude = $apartment['latitude'];
            $new_apartment->longitude = $apartment['longitude'];
            $new_apartment->is_visible = $faker->boolean();
            $new_apartment->save();
       }
    }
}

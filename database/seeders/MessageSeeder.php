<?php

namespace Database\Seeders;

use App\Models\Apartment;
use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Faker\Generator as Faker;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        Schema::disableForeignKeyConstraints();
        Message::truncate();
        Schema::enableForeignKeyConstraints();

        for ($i=0; $i < 10; $i++) { 
            $random_apartment = Apartment::inRandomOrder()->first(); // Get a random (full) record from apartment Model

            $new_message = new Message();
                $new_message->apartment_id = $random_apartment->id;

                $prob = rand(0,1);
                if( $prob ) {
                    $random_user = User::inRandomOrder()->first(); // Get a random (full) record from user Model
                    $new_message->email = $random_user->email;
                } else {
                    $new_message->email = $faker->email();
                }

                $new_message->content = $faker->paragraph(20);
            $new_message->save();
        }
    }
}

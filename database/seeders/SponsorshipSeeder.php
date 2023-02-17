<?php

namespace Database\Seeders;

use App\Models\sponsorship;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class SponsorshipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        sponsorship::truncate();
        Schema::enableForeignKeyConstraints();

        $sponsors = [
                [
                    'name' => 'Silver',
                    'price' => '2.99',
                    'duration' => '24'
                ],
                [
                    'name' => 'Gold',
                    'price' => '5.99',
                    'duration' => '72'
                ],
                [
                    'name' => 'Platinum',
                    'price' => '9.99',
                    'duration' => '144'
                ]
            ];

        foreach ($sponsors as $sponsor){
            $new_sponsor = new sponsorship();
            $new_sponsor->name = $sponsor['name'];
            $new_sponsor->price = $sponsor['price'];
            $new_sponsor->duration = $sponsor['duration'];
            $new_sponsor->save();
        }
    }
}

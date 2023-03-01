<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Service;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get all apartments owned by a logged in user
        $apartments = Apartment::with('user', 'services', 'sponsorships')->get();

        return $apartments;
    }

    public function apartments_w_services($services) {
        // Trasformo i servizi su cui filtrare in array 
        $service_array = explode(",", $services);

        // Inizializzo variabile degli appartmenti che verranno stampati
        $filtered_apartments=[];
        $apartments = Apartment::with('user', 'services', 'sponsorships')->get();

        // Ciclo su tutti gli appartamenti
        foreach ($apartments as $apartment) {
            $how_many_services = count($service_array);
            $services_found = 0;

            // Ciclo su tutti i servizi degli appartamenti
            foreach ($apartment->services as $apartment_service) {
                in_array( strtolower($apartment_service->name),  $service_array ) ? $services_found++ : '';
            }
            $how_many_services === $services_found ? $filtered_apartments[] = $apartment : '';
        }
        return $filtered_apartments;
    }

    public function show($slug){
        
        try {
            $apartment = Apartment::where('slug', $slug)->with('services', 'user', 'sponsorships')->firstOrFail();
            return $apartment;  
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response([
                'error' => '404 Apartment Not Found',
            ], 404);
        }

        return $apartment;
    }

    // public function search_by_address_with_filter($query, $services) {
    //     // Trasformo i servizi su cui filtrare in array 
    //     $service_array = explode(",", $services);

    //     // Inizializzo variabile degli appartmenti che verranno stampati
    //     $filtered_apartments=[];
    //     $apartments = Apartment::where('full_address', 'like', '%' . $query . '%')->with('user', 'services', 'sponsorships')->get();            

    //     // Ciclo su tutti gli appartamenti
    //     foreach ($apartments as $apartment) {
    //         $how_many_services = count($service_array);
    //         $services_found = 0;
            
    //         // Ciclo su tutti i servizi degli appartamenti
    //         foreach ($apartment->services as $apartment_service) {
    //             in_array( strtolower($apartment_service->name),  $service_array ) ? $services_found++ : '';
    //         }
    //         $how_many_services === $services_found ? $filtered_apartments[] = $apartment : '';
    //     }
    //     return $filtered_apartments;
    // }

    public function get_sponsored_apartments() {
        $sponsored_apartments = [];
        $apartments = Apartment::with('sponsorships', 'user', 'services')->get();

        foreach ($apartments as $i => $apartment) {
            if( !$apartment['sponsorships']->isEmpty() ) {
                // Get all sponsors from apartment in array
                $apartment_sponsors = $apartment['sponsorships']->toArray();

                // Get the last sponsor date time
                $last_sponsor = end($apartment_sponsors);
                $last_sponsor_end = $last_sponsor['pivot']['sponsor_end'];
            
                // Check if last sponsor end is passed
                $is_passed = Carbon::createFromFormat('Y-m-d H:i:s', $last_sponsor_end)->isPast();
                
                if( !$is_passed ) {
                    $sponsored_apartments[] = $apartment;
                }
            }
        }
        return $sponsored_apartments;
    }

    public function get_near_apartments($address, $radius, $rooms, $beds, $services) {
        $apartments = Apartment::where('rooms_num', '>=', $rooms)
        ->where('beds_num', '>=', $beds)
        ->with('sponsorships', 'user', 'services')->get();

        $near_aparments = [];

        $service_array = explode(",", strtolower($services));
        
        $coords = get_coords_from_address($address);
        
        foreach ($apartments as $apartment) {
            $how_many_services = count($service_array);
            $services_found = 0;

            // Ciclo su tutti i servizi degli appartamenti
            foreach ($apartment->services as $apartment_service) {
                in_array( strtolower($apartment_service->name),  $service_array ) ? $services_found++ : '';
            }
            if($how_many_services === $services_found){
                $latitude = $apartment['latitude'];
                $longitude = $apartment['longitude'];
    
                $distance = round(point2point_distance($coords['position']['lat'], $coords['position']['lon'], $latitude, $longitude));
    
                if( $distance <= $radius ) {
                    $near_aparments[] = $apartment;
                }
            }            
        }

        return [$near_aparments, $coords];
    }
}


/*---------------------
    FUNCTIONS
---------------------*/
    // Get coordinates from Query Address
    function get_coords_from_address($full_address) {
        $getCoordsFromAddress = Http::get("https://api.tomtom.com/search/2/geocode/{$full_address}.json?key=S7Di8WQbB2pqxqTH8RYmhO63cZwgtNgp&storeResult=true&typeahead=true&limit=1&view=Unified");
        $res = $getCoordsFromAddress->json();

        // Check if address is found by API
        if( $res !== null && $res['results'] !== [] ){
            return $res['results'][0];
        } else {
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'full_address' => ['Indirizzo non trovato.'],
            ]);
            throw $error;
        }
    }

    function point2point_distance($lat1, $lon1, $lat2, $lon2, $unit='K') 
    { 
        $theta = $lon1 - $lon2; 
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)); 
        $dist = acos($dist); 
        $dist = rad2deg($dist); 
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);

        if ($unit == "K") 
        {
            return ($miles * 1.609344); 
        } 
        else if ($unit == "N") 
        {
        return ($miles * 0.8684);
        } 
        else 
        {
        return $miles;
        }
    }   

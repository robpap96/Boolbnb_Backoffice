<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Service;
use Illuminate\Http\Request;

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

    public function search_by_address($query){
        $apartments = Apartment::where('full_address', 'like', '%' . $query . '%')->with('user', 'services', 'sponsorships')->get();            

        return $apartments;
    }

    public function search_by_address_with_filter($query, $services) {
        // Trasformo i servizi su cui filtrare in array 
        $service_array = explode(",", $services);

        // Inizializzo variabile degli appartmenti che verranno stampati
        $filtered_apartments=[];
        $apartments = Apartment::where('full_address', 'like', '%' . $query . '%')->with('user', 'services', 'sponsorships')->get();            

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
}

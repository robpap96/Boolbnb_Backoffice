<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreApartmentRequest;
use App\Http\Requests\UpdateApartmentRequest;
use App\Models\Apartment;
use App\Models\Service;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

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
        $apartments = Apartment::where('user_id', Auth::user()->id)->get();

        return view('admin.apartments.index', compact('apartments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $services = Service::All();

        return view('admin.apartments.create', compact('services'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreApartmentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreApartmentRequest $request)
    {
        $data = $request->validated();
        $new_apartment = new Apartment();
            $new_apartment->user_id = Auth::user()->id;

            $getCoordsFromAddress = Http::get("https://api.tomtom.com/search/2/geocode/{$data['full_address']}.json?key=S7Di8WQbB2pqxqTH8RYmhO63cZwgtNgp&storeResult=true&typeahead=true&limit=1&view=Unified");
            $answer = $getCoordsFromAddress->json();

            $new_apartment->image = Storage::disk('public')->put('uploads', $data['image']);

            $coords = $answer['results'][0]['position'];
            $new_apartment->latitude = $coords['lat'];
            $new_apartment->longitude = $coords['lon'];

            $fullAddress = "{$answer['results'][0]['address']['freeformAddress']}, {$answer['results'][0]['address']['countrySubdivision']}, {$answer['results'][0]['address']['country']}";
            $new_apartment->full_address = $fullAddress;
            
            if ( isset($data['is_visible']) ) {
                $new_apartment->is_visible = true;
            } else {
                $new_apartment->is_visible = false;
            }
            
            $new_apartment->fill($data);

        $new_apartment->save();
            
        if( isset($data['services']) ){
            $new_apartment->services()->sync($data['services']);
        }

        return redirect()->route('admin.apartments.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Apartment  $apartment
     * @return \Illuminate\Http\Response
     */
    public function show(Apartment $apartment)
    {
        return view('admin.apartments.show', compact('apartment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Apartment  $apartment
     * @return \Illuminate\Http\Response
     */
    public function edit(Apartment $apartment)
    {
        $services = Service::All();

        return view('admin.apartments.edit', compact('apartment', 'services'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateApartmentRequest  $request
     * @param  \App\Models\Apartment  $apartment
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateApartmentRequest $request, Apartment $apartment)
    {
        $data = $request->validated();
            if ( isset($data['image']) ) {
                // Removing old img in DB before adding new
                if ( $apartment->image ) {
                    Storage::disk('public')->delete($apartment->image);
                }
                $apartment->image = Storage::disk('public')->put('uploads', $data['image']);
            };

            if( $data['full_address'] != $apartment->full_address ){
                $getCoordsFromAddress = Http::get("https://api.tomtom.com/search/2/geocode/{$data['full_address']}.json?key=S7Di8WQbB2pqxqTH8RYmhO63cZwgtNgp&storeResult=true&typeahead=true&limit=1&view=Unified");
                $answer = $getCoordsFromAddress->json();
        
                $coords = $answer['results'][0]['position'];
                $apartment->latitude = $coords['lat'];
                $apartment->longitude = $coords['lon'];

                $fullAddress = "{$answer['results'][0]['address']['freeformAddress']}, {$answer['results'][0]['address']['countrySubdivision']}, {$answer['results'][0]['address']['country']}";
                $apartment->full_address = $fullAddress;
            }

            if ( isset($data['is_visible']) ) {
                $apartment->is_visible = true;
            } else {
                $apartment->is_visible = false;
            }
        $apartment->update($data);

        if( isset($data['services']) ) {
            // Save records into pivot table if $data['services] is isset
            $apartment->services()->sync($data['services']);
        } else {
            // Else every record to its apartment is cancelled
            $apartment->services()->sync([]);
        }

        return redirect()->route('admin.apartments.show', $apartment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Apartment  $apartment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Apartment $apartment)
    {
        if ( $apartment->image ) {
            Storage::disk('public')->delete($apartment->image);
        }

        $apartment->delete();

        return redirect()->route('admin.apartments.index');;
    }
}

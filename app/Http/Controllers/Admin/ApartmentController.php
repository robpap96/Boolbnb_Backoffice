<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreApartmentRequest;
use App\Http\Requests\UpdateApartmentRequest;
use App\Models\Apartment;
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
        return view('admin.apartments.create');
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

        $new_apartment->image = Storage::disk('public')->put('uploads', $data['image']);
        
        $getCoordsFromAddress = Http::get("https://api.tomtom.com/search/2/geocode/{$data['full_address']}.json?key=S7Di8WQbB2pqxqTH8RYmhO63cZwgtNgp&storeResult=true&typeahead=true&limit=1&view=Unified");
        $answer = $getCoordsFromAddress->json();
        $coords = $answer['results'][0]['position'];
        $new_apartment->latitude = $coords['lat'];
        $new_apartment->longitude = $coords['lon'];

        if ( isset($data['is_visible']) ) {
            $new_apartment->is_visible = 1;
        } else {
            $new_apartment->is_visible = 0;
        }
        
        $new_apartment->fill($data);
        $new_apartment->save();

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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Apartment  $apartment
     * @return \Illuminate\Http\Response
     */
    public function edit(Apartment $apartment)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Apartment  $apartment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Apartment $apartment)
    {
        //
    }
}

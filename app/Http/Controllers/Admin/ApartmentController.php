<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreApartmentRequest;
use App\Http\Requests\UpdateApartmentRequest;
use App\Models\Apartment;
use App\Models\Service;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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
        $apartments = Apartment::where('user_id', Auth::user()->id)->get();
        $services = Service::All();

        return view('admin.apartments.create', compact('services', 'apartments'));
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

        // Check if chosen title is unique or not
        $apartments = Apartment::where('user_id', Auth::user()->id)->where('title', $data['title'])->get()->toArray();

        // If apartments is empty then title is unique
        if ( $apartments === [] ) {
            $new_apartment = new Apartment();

                $new_apartment->user_id = Auth::user()->id;
    
                // function to get coords from address query
                $answer = get_coords_from_address($data['full_address']);
    
                // Set Lat and Lon
                $new_apartment->latitude = $answer['position']['lat'];
                $new_apartment->longitude = $answer['position']['lon'];
    
                // Save full address from API answer
                $answer_address = $answer['address'];
                $new_apartment->full_address = "{$answer_address['freeformAddress']}, {$answer_address['countrySubdivision']}, {$answer_address['country']}";
    
                // Save image in server storage
                $new_apartment->image = Storage::disk('public')->put('uploads', $data['image']);
                
                isset($data['is_visible']) ? ($new_apartment->is_visible = true) : ($new_apartment->is_visible = false);
    
                $new_apartment->fill($data);
    
                // Get slug from apartment info
                $new_apartment->slug = create_slug($new_apartment->title, $new_apartment->user_id, $new_apartment->full_address, $new_apartment->getNextId());
            $new_apartment->save();
                
            if( isset($data['services']) ){
                $new_apartment->services()->sync($data['services']);
            }
        } else {
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'title' => ['Title already exists.'],
            ]);
            throw $error;
        }

        return redirect()->route('admin.apartments.show', $new_apartment->slug);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Apartment  $apartment
     * @return \Illuminate\Http\Response
     */
    public function show(Apartment $apartment)
    {
        $last_active_sponsor = 'null';
        $apartments = Apartment::where('user_id', Auth::user()->id)->get();

        if( $apartment->user_id === Auth::user()->id ){

            // Check if showed apartment is sponsored
            if( !$apartment->sponsorships->isEmpty() ) {
                // Get all sponsors from apartment in array
                $apartment_sponsors = $apartment['sponsorships']->toArray();

                // Get the last sponsor date time
                $last_sponsor = end($apartment_sponsors);
                $last_sponsor_end = $last_sponsor['pivot']['sponsor_end'];
            
                // Check if last sponsor end is passed
                $is_passed = Carbon::createFromFormat('Y-m-d H:i:s', $last_sponsor_end)->isPast();
                
                if( !$is_passed ) {
                    $last_active_sponsor = $last_sponsor_end;
                }
            }
            return view('admin.apartments.show', compact('apartment', 'last_active_sponsor', 'apartments'));
        } else {
            return redirect()->route('admin.apartments.index')->with('invalid_op', 'Invalid operation.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Apartment  $apartment
     * @return \Illuminate\Http\Response
     */
    public function edit(Apartment $apartment)
    {
        $apartments = Apartment::where('user_id', Auth::user()->id)->get();

        if( $apartment->user_id === Auth::user()->id ){
            $services = Service::All();

            return view('admin.apartments.edit', compact('apartment', 'services', 'apartments'));
        } else {
            return redirect()->route('admin.apartments.index');
        }
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

        $apartments = Apartment::where('user_id', Auth::user()->id)->where('id', '!=', $apartment->id)->where('title', $data['title'])->get()->toArray();
        
        if ( $apartments === [] ) {
            if ( isset($data['image']) ) {
                // Removing old img in DB before adding new
                if ( $apartment->image ) {
                    Storage::disk('public')->delete($apartment->image);
                }
                $apartment->image = Storage::disk('public')->put('uploads', $data['image']);
            };
    
            if( $data['full_address'] != $apartment->full_address ){
                // function to get coords from address query
                $answer = get_coords_from_address($data['full_address']);
    
                // Set Lat and Lon
                $apartment->latitude = $answer['position']['lat'];
                $apartment->longitude = $answer['position']['lon'];;
    
                // Save full address from API answer
                $answer_address = $answer['address'];
                $apartment->full_address = "{$answer_address['freeformAddress']}, {$answer_address['countrySubdivision']}, {$answer_address['country']}";
            }
    
            // Get slug from apartment info
            $apartment->slug = create_slug($data['title'], $apartment->user_id, $apartment->full_address, $apartment->id);
    
            isset($data['is_visible']) ? ($apartment->is_visible = true) : ($apartment->is_visible = false);
            $apartment->update($data);
        
            if( isset($data['services']) ) {
                // Save records into pivot table if $data['services] is isset
                $apartment->services()->sync($data['services']);
            } else {
                // Else every record to its apartment is cancelled
                $apartment->services()->sync([]);
            }
        }  else {
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'title' => ['Title already exists.'],
            ]);
            throw $error;
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
        if( $apartment->user_id === Auth::user()->id ){
            if ( $apartment->image ) {
                Storage::disk('public')->delete($apartment->image);
            }
            $apartment->delete();

            return redirect()->route('admin.apartments.index');;
        } else {
            abort(403, 'You are trying to delete an apartment that doesn\'t exist.');
        }
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

    // Get Slug
    function create_slug($title, $user_id, $address, $apartment_id) {
        $slug = Str::slug($title, '-') . '-' . Str::slug($address, '-') . '-' . Str::slug($user_id, '-') . '-' . Str::slug($apartment_id, '-');

        return $slug;
    }

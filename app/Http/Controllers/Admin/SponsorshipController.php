<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoresponsorshipRequest;
use App\Http\Requests\UpdatesponsorshipRequest;
use App\Models\sponsorship;
use App\Http\Controllers\Controller;
use App\Models\Apartment;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class SponsorshipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sponsorships = sponsorship::all();

        return view('admin.sponsors.index', compact('sponsorships'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoresponsorshipRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoresponsorshipRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\sponsorship  $sponsorship
     * @return \Illuminate\Http\Response
     */
    public function show(sponsorship $sponsor)
    {
        $apartments = Apartment::where('user_id', Auth::user()->id)->get();

        return view('admin.sponsors.show', compact('sponsor', 'apartments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\sponsorship  $sponsorship
     * @return \Illuminate\Http\Response
     */
    public function edit(sponsorship $sponsorship)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatesponsorshipRequest  $request
     * @param  \App\Models\sponsorship  $sponsorship
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatesponsorshipRequest $request, sponsorship $sponsorship)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\sponsorship  $sponsorship
     * @return \Illuminate\Http\Response
     */
    public function destroy(sponsorship $sponsorship)
    {
        //
    }

    public function buy_sponsor(Request $request, $slug, sponsorship $sponsorship){
        // Validation check for apartment id
        $data = $request->validate([
            'apartment_sponsored' => 'required|numeric|exists:apartments,id',
        ]);

        // Get the apartment record from $data
        $apartment = Apartment::find($data['apartment_sponsored']);

        // Throw an error if the user id don't match
        $apartment->toArray()['user_id'] !== Auth::user()->id ? trow_error('Operazione non consentita!') : '';

        // Get sponsor from the slug
        $sponsorship = sponsorship::where('slug', $slug)->first();

        // See if apartment has sponsors
        $apartment_sponsors = $apartment->sponsorships()->get()->toArray();

        if ($apartment->is_visible) {
            if( $apartment_sponsors === [] ){
                make_a_sponsor($sponsorship, $data, $time = Carbon::now());
            } else {
                // Get the last sponsor date time
                $last_sponsor = end($apartment_sponsors);
                $last_sponsor_end = $last_sponsor['pivot']['sponsor_end'];

                // Check if last sponsor end is passed
                $is_passed = Carbon::createFromFormat('Y-m-d H:i:s', $last_sponsor_end)->isPast();

                if( $is_passed ) {
                    make_a_sponsor($sponsorship, $data, $time = Carbon::now());
                } else {
                    make_a_sponsor($sponsorship, $data, $time = $last_sponsor_end);
                }
            }
        } else {
            trow_error('Non puoi sponsorizzare un appartamento che non è visibile.');
        }

        return redirect()->route('admin.sponsors.show', $sponsorship)->with('message', 'Appartamento sponsorizzato con successo!');
    }   
}


/*---------------------
    FUNCTIONS
---------------------*/
    // Make a sponsor
    function make_a_sponsor($sponsorship, $data, $time){
        $sponsor_start = $time;

        // Split Year[0] from time[1]
        $split_start = explode(' ', $sponsor_start);

        switch ($sponsorship->id) {
            case '1':
                // 24 hours sponsor
                $get_sponsor_end = date('Y-m-d', strtotime($split_start[0] . '+ 1 days'));
                $sponsor_end = "{$get_sponsor_end} {$split_start[1]}";
                break;
            case '2':
                // 72 hours sponsor
                $get_sponsor_end = date('Y-m-d', strtotime($split_start[0] . '+ 3 days'));
                $sponsor_end = "{$get_sponsor_end} {$split_start[1]}";
                break;
            case '3':
                // 144 hours sponsor
                $get_sponsor_end = date('Y-m-d', strtotime($split_start[0] . '+ 6 days'));
                $sponsor_end = "{$get_sponsor_end} {$split_start[1]}";
                break;
            default:
                break;
        }
        
        $sponsorship->apartments()->attach($data, [
            'sponsor_start' => $sponsor_start,
            'sponsor_end' => $sponsor_end,
        ]);
    }

    // Trow an error with a custom message
    function trow_error($message){
        $error = \Illuminate\Validation\ValidationException::withMessages([
            'apartment_sponsored' => [$message],
        ]);
        throw $error;
    }
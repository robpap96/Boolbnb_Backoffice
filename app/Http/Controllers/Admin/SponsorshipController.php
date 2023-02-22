<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoresponsorshipRequest;
use App\Http\Requests\UpdatesponsorshipRequest;
use App\Models\sponsorship;
use App\Http\Controllers\Controller;
use App\Models\Apartment;
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

    public function buy_sponsor(Request $request, $name, sponsorship $sponsorship){
        $data = $request->validate([
            'apartments_sponsored' => 'numeric',
        ]);

        // Get the sponsor from the name
        $sponsorship = sponsorship::where('name', $name)->first();

        $sponsor_start = Carbon::now();

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

        return redirect()->route('admin.sponsors.show', $sponsorship)->with('message', 'Appartamento sponsorizzato con successo!');
    }   
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $client = $request->user()->client;

        if (!$client) {
            return response()->json(['message' => 'No client associated with this user'], 404);
        }

        $locations = Location::with('vehicule')
            ->where('client_id', $client->id)
            ->get();

        return response()->json($locations);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'vehicule_id' => 'required|exists:vehicules,id',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
        ]);

        $client = $request->user()->client;

        if (!$client) {
            return response()->json(['message' => 'No client associated with this user'], 404);
        }

        $vehicule = Vehicule::find($validated['vehicule_id']);
        $days = (new \DateTime($validated['date_fin']))->diff(new \DateTime($validated['date_debut']))->days + 1;

        $location = Location::create([
            'client_id' => $client->id,
            'vehicule_id' => $validated['vehicule_id'],
            'date_debut' => $validated['date_debut'],
            'date_fin' => $validated['date_fin'],
            'montant_total' => $vehicule->prix_journalier * $days,
        ]);

        return response()->json($location, 201);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

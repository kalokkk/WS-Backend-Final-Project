<?php

namespace App\Http\Controllers;

use App\Models\Campsite;
use App\Models\CampsiteSpot;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CampsiteSpotController extends Controller
{
    public function index()
    {
        $campsite_spots = CampsiteSpot::with(['campsite'])->paginate(10);


        return Inertia::render('CampsiteSpot/List', ['campsite_spots' => $campsite_spots]);
    }

    public function new()
    {

        $campsites = $this->loadCampsiteList();

        return Inertia::render('CampsiteSpot/Edit', ['form' => [
            'name' => null,
            'campsite_id' => null,
        ], 'campsites' => $campsites]);
    }

    public function show(CampsiteSpot $campsite_spot)
    {

        $campsites = $this->loadCampsiteList();

        return Inertia::render('CampsiteSpot/Edit', ['form' => $campsite_spot, 'campsites' => $campsites]);
    }

    public function store(Request $request, CampsiteSpot $campsite_spot)
    {
        $validated = $this->validate($request, [
            'name' => 'required',
            'campsite_id' => [
                'required',
                'exists:campsites,id'
            ]
        ]);

        // save parent model
        $campsite_spot->fill($validated);
        $campsite_spot->save();

        return response()->redirectToRoute("campsite_spots.index");
    }

    public function destroy(CampsiteSpot $campsite_spot)
    {
        $campsite_spot->delete();
        return response()->redirectToRoute("campsite_spots.index");
    }

    public function loadCampsiteList()
    {
        return Campsite::all()->map(function ($campsite) {
            return [
                'id' => $campsite->id,
                'name' => $campsite->name,
            ];
        });
    }
}

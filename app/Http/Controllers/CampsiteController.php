<?php

namespace App\Http\Controllers;

use App\Models\Campsite;
use App\Models\CampsiteImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;
use Inertia\Inertia;

class CampsiteController extends Controller
{
    public function index()
    {
        $campsites = Campsite::paginate(10);

        return Inertia::render('Campsite/List', ['campsites' => $campsites]);
    }

    public function new()
    {
        return Inertia::render('Campsite/Edit', ['form' => [
            'name' => null,
            'description' => null,
            'location' => null,
        ]]);
    }

    public function show(Campsite $campsite)
    {
        $campsite->load(['campsite_images']);

        return Inertia::render('Campsite/Edit', ['form' => $campsite]);
    }

    public function store(Request $request, Campsite $campsite)
    {
        $validated = $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'location' => 'required',
            'file' => [
                'nullable',
                File::image()
            ]
        ]);

        DB::transaction(function () use ($campsite, $validated, $request) {

            // save parent model
            $campsite->fill($validated);
            $campsite->save();

            // save uploaded images
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $path = $file->store("images");
                $campsite->campsite_images()->save(new CampsiteImage([
                    'image_path' => $path,
                ]));
            }
        });

        return response()->redirectToRoute("campsites.index");
    }

    public function destroy(Campsite $campsite)
    {
        $campsite->delete();
        return response()->redirectToRoute("campsites.index");
    }

    public function show_campsite_image(Campsite $campsite, CampsiteImage $campsite_image)
    {
        return Storage::download($campsite_image->image_path);
    }
}

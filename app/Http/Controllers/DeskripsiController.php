<?php

namespace App\Http\Controllers;

use App\Models\Deskripsi;
use App\Models\Program;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDeskripsiRequest;
use App\Http\Requests\UpdateDeskripsiRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class DeskripsiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Deskripsi Laman Sistem Informasi & Inspace';
        $desk = Deskripsi::all();
        $programs = Program::where('is_active', 1)->get();

        return view('deskripsi.index', [
            'title' => $title,
            'deskripsi' => $desk,
            'programs' => $programs,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Deskripsi $deskripsi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Deskripsi $deskripsi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'tittle'=> 'required',
            'deskripsi'=> 'required',
        ]);

        // Find the FAQ record by its ID
        $desk = Deskripsi::findOrFail($id);

        // Update the FAQ record with the new data
        $desk->tittle = $validatedData['tittle'];
        $desk->deskripsi = $validatedData['deskripsi'];

        $desk->tittle = $request->input('tittle');
        $desk->short_description = $request->input('short_description');
        $desk->link = $request->input('link');
        $desk->deskripsi = $request->input('deskripsi');

        if ($request->foto) {
            // Remove the old file from the uploads folder
            if ($desk->foto && File::exists(public_path('images/' . $desk->foto))) {
                File::delete(public_path('images/' . $desk->foto));
            }

            // Store the updated image file
            $image = $request->file('foto');
            $imageName = Str::random(12) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $desk->foto = $imageName;
        }
        $desk->save();
        addToLog('Update deksripsi');

        // Redirect to the appropriate page with a success message
        return redirect()->route('deskripsi.index')->with('success', 'Description updated successfully');    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Deskripsi $deskripsi)
    {
        //
    }
}

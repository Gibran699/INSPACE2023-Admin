<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\Medpart;
use Illuminate\Support\Str;


class MedpartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $title = 'Medpart';
        $data = Medpart::all();
        return view('medpart.index', [
            'title' => $title,
            'data' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Add Medpart';
        return view('medpart.create', [
            'title' => $title,
        ]);
    }

    public function activateProgram($id)
    {
        if (request()->ajax()) {
            $medpart = Medpart::find($id);
            $medpart->update(['is_active' =>$medpart->medpart== 1 ? 0 :1]);

            return response()->json(['massage' => 'Status has been updated'], 200);
        }
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the form data

        $image = $request->file('gambar');
        $imageName = Str::random(12) . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('uploads'), $imageName);

        // Create a new Medpart instance
        $medpart = new Medpart();
        $medpart->nama_medpart = $request->input('nama_medpart');
        $medpart->gambar = $imageName;
        // $medpart->is_active = 1;

        // Save the Medpart instance to the database
        $medpart->save();

        // Redirect back with a success message
        return redirect()->route('medpart.index')->with('success', 'Medpart added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Medpart $medpart)
    {
        $title = 'Edit Media Partner';

        return view('medpart.edit', [
            'title' => $title,
            'medpart' => $medpart,
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    /**
 * Update the specified resource in storage.
 */

    public function update(Request $request, string $id)
    {
        try {
            // Find the Medpart instance to update
            $medpart = Medpart::findOrFail($id);

            $medpart->nama_medpart = $request->input('nama_medpart');

            if ($request->gambar) {
                // Remove the old file from the uploads folder
                if ($medpart->gambar && File::exists(public_path('uploads/' . $medpart->gambar))) {
                    File::delete(public_path('uploads/' . $medpart->gambar));
                }

                // Store the updated image file
                $image = $request->file('gambar');
                $imageName = Str::random(12) . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads'), $imageName);
                $medpart->gambar = $imageName;
            }

            // Save the updated Medpart instance to the database
            $medpart->save();

            // Redirect back with a success message
            return redirect()->route('medpart.index')->with('success', 'Medpart updated successfully.');
        } catch (\Exception $e) {
            // Handle the exception, e.g., show an error message
            return response()->json(["status" => "error", "message" => $e->getMessage()]);
        }
    }


    public function toggleActive($id)
    {
        try {
            $medpart = Medpart::find($id);

            if (!$medpart) {
                return response()->json(['message' => 'Medpart not found'], 404);
            }

            $medpart->is_active = !$medpart->is_active; // Toggle the value

            $medpart->save();

            return response()->json(['message' => 'Medpart status updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update medpart status'], 500);
        }
    }
    public function getData()
    {
        if (request()->ajax()) {
            $medpart = Medpart::all();

            return response()->json($medpart);
        }

        return abort(404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Medpart $medpart)
    {
        $filePath = public_path('uploads/' . $medpart->gambar);

        // Delete the file if it exists
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        $medpart->delete();

        return redirect()->route('medpart.index')->with('success', 'Medpart successfully deleted.');
    }
}

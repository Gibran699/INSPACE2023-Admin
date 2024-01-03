<?php

namespace App\Http\Controllers;

use App\Models\Division;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    public function index()
    {
        if (auth()->guard('comittee')->user()->isWebDev()) {
            return view('division.index',['title' => 'Division']);
        }
        abort(404);
    }

    public function getData()
    {
        if (request()->ajax()) {
            $divisions = Division::all();
            return response()->json($divisions);
        }
        abort(404);
    }

    public function store(Request $request)
    {
        if (request()->ajax()) {
            Division::create([
                'name' => $request->name,
                'accessmenu' => $request->has('accessmenu') ? json_encode($request->accessmenu) : null
            ]);
            addToLog('Menambah divisi');
            return response()->json(['message' => 'Division successfully saved.'], 200);
        }
        abort(404);
    }

    public function show(Division $division)
    {
        if (request()->ajax()) {
            return response()->json($division, 200);
        }
        abort(404);
    }

    public function update(Request $request, Division $division)
    {
        if (request()->ajax()) {
            $division->update([
                'name' => $request->name,
                'accessmenu' => $request->has('accessmenu') ? json_encode($request->accessmenu) : null
            ]);
            addToLog('Update divisi');
            return response()->json(['message' => 'Division successfully updated.'], 200);
        }
        abort(404);
    }
}

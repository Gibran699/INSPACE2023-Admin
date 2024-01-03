<?php

namespace App\Http\Controllers;

use App\Models\Addon;
use App\Models\AddonVariant;
use Illuminate\Http\Request;

class AddonVariantController extends Controller
{
    public function index()
    {
        return view('addonvariant.index', [
            'title' => 'Addon Variant'
        ]);
    }

    public function getData()
    {
        if (request()->ajax()) {
            $variant = AddonVariant::latest()->get();
            return response()->json($variant, 200);
        }
    }

    public function store(Request $request)
    {
        if (request()->ajax()) {
            AddonVariant::create([
                'name' => $request->name,
                'price' => $request->price,
                'stock' => $request->stock,
                'is_active' => 0
            ]);
            addToLog('Menambah Addon Variant');
            return response()->json(['message' => 'Addon variant successfully saved!'], 200);
        }
        abort(404);
    }

    public function activateAddon(AddonVariant $variant)
    {
        if (request()->ajax()) {
            $variant->update(['is_active' => $variant->is_active ? 0 : 1]);
            addToLog('Aktivasi Addon Variant');

            return response()->json(['message' => 'Addon successfully updated!']);
        }
        abort(404);
    }

    public function show(AddonVariant $variant)
    {
        if (request()->ajax()) {
            return response()->json($variant, 200);
        }
    }

    public function update(Request $request, AddonVariant $variant)
    {
        if (request()->ajax()) {
            $variant->update($request->except(['_token']));
            addToLog('Update Addon');
            return response()->json(['message' => 'Addon successfully update!'], 200);
        }
        abort(404);
    }
}

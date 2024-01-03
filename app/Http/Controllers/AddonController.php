<?php

namespace App\Http\Controllers;

use App\Models\Addon;
use App\Models\AddonVariant;
use Illuminate\Http\Request;
use File;
use Illuminate\Support\Str;

class AddonController extends Controller
{
    public function index(AddonVariant $variant)
    {
        return view('addonvariant.addon', [
            'title' => 'Addon',
            'variant' => $variant
        ]);
    }

    public function getData($variant)
    {
        if (request()->ajax()) {
            $addon = Addon::where('id_addon_variant', $variant)->latest()->get();
            return response()->json($addon, 200);
        }
    }

    private function saveFile($file, $path, $old_file = null)
    {
        if ($old_file) {
            if (File::exists(public_path($path). $old_file )) {
                FIle::delete(public_path($path). $old_file );
            }
        }

        $filename = STR::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)). '.' .$file->getClientOriginalExtension();

		$file->move($path,$filename);

        return $filename;
    }

    public function store(Request $request, AddonVariant $variant)
    {
        if (request()->ajax()) {
            Addon::create([
                'image' => $this->saveFile($request->image, 'file/addon/'),
                'stock' => $request->stock,
                'id_addon_variant' => $variant->id
            ]);
            addToLog('Menambah Addon dalam '. $variant->name);
            return response()->json(['message' => 'Addon successfully saved!'], 200);
        }
        abort(404);
    }

    public function show(AddonVariant $variant, Addon $addon)
    {
        if (request()->ajax() && $addon->addonVariant->id === $variant->id) {
            return response()->json($addon, 200);
        }
    }

    public function update(Request $request, AddonVariant $variant, Addon $addon)
    {
        if (request()->ajax()) {
            $addon->update([
                'image' => $request->hasFile('image') ? $this->saveFile($request->image, 'file/addon/', $addon->image) : $addon->image,
                'stock' => $request->stock,
            ]);
            addToLog('Mengubah Addon dalam '. $variant->name);
            return response()->json(['message' => 'Addon successfully updated!']);
        }
        abort(404);
    }
}

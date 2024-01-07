<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LocationController extends Controller
{ 
    public function index()
    {
        $locations = Location::with('galleries')->get();
        return response()->json(['locations' => $locations], 200);
    }
    public function show($id)
    {
        $location = Location::find($id);

        if (!$location) {
            return response()->json(['message' => 'Location not found'], 404);
        }

        return response()->json(['location' => $location], 200);
    }

    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_location' => 'required|unique:locations',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Simpan data lokasi
        $location = Location::create([
            'nama_location' => $request->input('nama_location'),
        ]);

        return response()->json(['location' => $location], 201);
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_location' => 'required|unique:locations',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $location = Location::find($id);

        if (!$location) {
            return response()->json(['message' => 'Location Tidak Ada'], 404);
        }

        // Update data lokasi
        $location->nama_location = $request->input('nama_location');
        $location->save();

        return response()->json(['location' => $location], 200);
    }

    public function destroy($id)
    {
        $location = Location::find($id);

        if (!$location) {
            return response()->json(['data' => 'Location Tidak Ada'], 404);
        }

        // Hapus data lokasi dari database
        $location->delete();

        return response()->json(['data' => 'Hapus Location Berhasil'], 200);
    }

}


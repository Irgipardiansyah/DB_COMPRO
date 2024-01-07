<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::with('location')->get();

        return response()->json(['galleries' => $galleries], 200);
    }

    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'video' => 'required|mimes:mp4,mov,avi,wmv,mkv',
            'nama_location' => 'required|exists:locations,nama_location',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Upload video
        $videoPath = $request->file('video')->store('videos', 'public');

        // Cari lokasi berdasarkan nama
        $location = Location::where('nama_location', $request->input('nama_location'))->first();
        // Buat lokasi baru jika tidak ditemukan
        if (!$location) {
            $location = Location::create([
                'nama_location' => $request->input('nama_location'),
                // tambahkan field lain sesuai kebutuhan
            ]);
        }

        // Simpan data galeri
        $gallery = Gallery::create([
            'nama' => $request->input('nama'),
            'video' => $videoPath,
            'location_id' => $location->id,
        ]);

        return response()->json(['gallery' => $gallery], 201);
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'nama_location' => 'required|exists:locations,nama_location',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $gallery = Gallery::find($id);

        if (!$gallery) {
            return response()->json(['message' => 'Gallery not found'], 404);
        }
        // Cari lokasi berdasarkan nama
        $location = Location::where('nama_location', $request->input('nama_location'))->first();
        // Buat lokasi baru jika tidak ditemukan
        if (!$location) {
            $location = Location::create([
                'nama_location' => $request->input('nama_location'),
                // tambahkan field lain sesuai kebutuhan
            ]);
        }
        // Update data galeri
        $gallery->nama = $request->input('nama');
        $gallery->location_id = $location->id;

        // Cek apakah ada permintaan untuk mengubah video
        if ($request->hasFile('video')) {
            // Hapus video lama jika ada
            if ($gallery->video) {
                Storage::disk('public')->delete($gallery->video);
            }
            // Upload video baru
            $videoPath = $request->file('video')->store('videos', 'public');
            $gallery->video = $videoPath;
        }

        $gallery->save();

        return response()->json(['gallery' => $gallery], 200);
    }
}

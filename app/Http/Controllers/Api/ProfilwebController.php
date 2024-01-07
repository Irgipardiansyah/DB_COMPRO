<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Profilweb;
use Illuminate\Http\Request;

class ProfilwebController extends Controller
{
    public function index()
    {
        $profilwebs = ProfilWeb::first();
        return response()->json($profilwebs, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string',
            'sub_judul' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $existingProfilwebCount = ProfilWeb::count();

        if ($existingProfilwebCount > 0) {
            $profilweb = ProfilWeb::first(); // Get the first record
            $profilweb->update([
                'judul' => $request->input('judul'),
                'sub_judul' => $request->input('sub_judul'),
            ]);
            return response()->json(['Data berhasil diupdate', $profilweb], 200);
        }

        $profilweb = ProfilWeb::create([
            'judul' => $request->judul,
            'sub_judul' => $request->sub_judul,
        ]);

        return response()->json(['Data berhasil ditambahkan',$profilweb], 201);
    }

    public function destroy()
    {
        ProfilWeb::truncate();

        return response()->json(['message' => 'Data berhasil dihapus'], 200);
    }
    
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    public function index()
    {
        $contacts = Message::all(); // Mengambil semua data tanpa pembagian halaman

        return response()->json(['pesan' => $contacts], 200);
    }

    public function show($id)
    {
        $contact = Message::findOrFail($id);

        return response()->json(['pesan' => $contact], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'email' => 'required|email',
            'no_hp' => 'required',
            'pesan' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $contact = Message::create([
            'nama' => $request->input('nama'),
            'email' => $request->input('email'),
            'no_hp' => $request->input('no_hp'),
            'pesan' => $request->input('pesan'),
        ]);

        return response()->json(['pesan' => $contact], 201);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'email' => 'required|email',
            'no_hp' => 'required',
            'pesan' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $contact = Message::findOrFail($id);

        $contact->update([
            'nama' => $request->input('nama'),
            'email' => $request->input('email'),
            'no_hp' => $request->input('no_hp'),
            'pesan' => $request->input('pesan'),
        ]);

        return response()->json(['pesan' => $contact], 200);
    }

    public function destroy($id)
    {
        $contact = Message::findOrFail($id);
        $contact->delete();

        return response()->json(['pesan' => 'berhasil di hapus'], 200);
    }
}

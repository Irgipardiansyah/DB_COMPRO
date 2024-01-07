<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        return response()->json(['users' => $users], 200);
    }
    public function create(Request $body)
    {
        $validator = Validator::make($body->all(),[
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()){
            return response()->json($validator->errors(),400);
        }
        $name=$body->name;
        $email=$body->email;
        $password=$body->password;

        $user=User::create([
            'name'=> $name,
            'email' => $email,
            'password' =>bcrypt($password),
        ]);
        return response()->json('Berhasil',200);
    }
    public function update(Request $request, $id)
    {
        // input
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:users,username,'.$id,
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'password' => 'nullable|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Update data user
        $user->username = $request->input('username');
        $user->email = $request->input('email');

        // Update password jika ada perubahan
        if ($request->has('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        $user->save();

        return response()->json(['user' => $user], 200);
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Hapus user
        $user->delete();

        return response()->json(['message' => 'User deleted successfully'], 200);
    }
}

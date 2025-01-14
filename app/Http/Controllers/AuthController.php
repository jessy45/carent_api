<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // Enregistrer un utilisateur et créer un client associé
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'adresse' => 'nullable|string',
            'telephone' => 'nullable|string|max:15',
            'permis' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $client = Client::create([
            'user_id' => $user->id,
            'adresse' => $request->adresse,
            'telephone' => $request->telephone,
            'permis' => $request->permis,
        ]);

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'user' => $user,
            'client' => $client,
            'token' => $token,
        ], 201);
    }

    // Connecter un utilisateur
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'user' => $user,
            'client' => $user->client,
            'token' => $token,
        ], 200);
    }

    // Mettre à jour les informations utilisateur et client
    public function update(Request $request)
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'adresse' => 'nullable|string',
            'telephone' => 'nullable|string|max:15',
            'permis' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $user->client->update($request->only('adresse', 'telephone', 'permis'));

        return response()->json([
            'message' => 'User and client information updated successfully.',
            'user' => $user,
            'client' => $user->client,
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role'     => 'in:apprenant,formateur',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role ?? 'apprenant',
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user'  => $user,
            'token' => $token,
        ], 201);
    }

    
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Email ou mot de passe incorrect.'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user'  => $user,
            'token' => $token,
        ]);
    }

    
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Déconnecté avec succès.']);
    }

    public function updateProfile(Request $request)
{
    $request->validate([
        'name'  => 'required|string|max:100',
        'email' => 'required|email|unique:users,email,' . $request->user()->id, //Check that this email is unique among all users except the one with this ID
    ]); 

    $user = $request->user();
    $user->name  = $request->name;
    $user->email = $request->email;
    $user->save();

    return response()->json($user);
}

public function updatePassword(Request $request)
{
    $request->validate([
        'current_password' => 'required',
        'new_password'     => 'required|min:6',
    ]);

    $user = $request->user();

    if (!Hash::check($request->current_password, $user->password)) {
        return response()->json(['message' => 'Mot de passe actuel incorrect.'], 400);
    }

    $user->password = Hash::make($request->new_password);
    $user->save();

    return response()->json(['message' => 'Mot de passe mis à jour.']);
}


    // GET /api/me
    // public function me(Request $request)
    // {
    //     return response()->json($request->user());
    // }
}
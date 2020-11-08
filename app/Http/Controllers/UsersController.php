<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function index() {
        return User::all();
    }

    public function show(User $user) {
        return $user;
    }

    public function store(Request $request) {
        $json = json_decode($request->getContent(), true);
        $json['password'] = Hash::make($json['password']);
        $user = User::create(
            $json
        );
        return response()->json($user, 201);
    }

    public function update(Request $request, User $user) {
        $json = json_decode($request->getContent(), true);
        $user->update($json);
        return response()->json($user, 200);
    }

    public function delete(User $user) {
        $user->delete();
        return response()->json(null, 204);
    }

    public function isAuthorized() {
        return response()->json([
            'user' => Auth::user()
        ]);
    }

    public function login(Request $request) {
        $json = json_decode($request->getContent(), true);
        $user = User::where(['login' => $json['login']])->first();

        if ($user) {
            Auth::login($user, $json['remember']);
            return response()->json([
                'user' => $user,
                'login' => true
            ], 200);
        }
        
        return response()->json([
            'user' => null,
            'login' => false
        ], 200);
    }

    public function logout(Request $request) {
        Auth::logout();

        return response()->json([
            'user' => null,
            'login' => false
        ], 204);
    }
}

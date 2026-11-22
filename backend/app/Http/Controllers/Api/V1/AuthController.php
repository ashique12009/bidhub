<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller {
  public function login(Request $request) {
    $credentials = $request->validate([
      'email'    => ['required', 'email'],
      'password' => ['required'],
    ]);

    if (!Auth::attempt($credentials)) {
      return response()->json([
        'message' => 'Invalid credentials.',
      ], 401);
    }

    $user = Auth::user();

    $token = $user->createToken('vue-biding-app')->plainTextToken;

    return response()->json([
      'user'  => $user,
      'token' => $token,
    ]);
  }
}
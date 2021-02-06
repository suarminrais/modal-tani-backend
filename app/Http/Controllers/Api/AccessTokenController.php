<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;

class AccessTokenController extends Controller
{
    public function store(LoginRequest $request)
    {
        $this->validate($request,[
            'device_name' => 'required|string',
        ]);

        $request->authenticate();

        $user = User::where('email', $request->email)->first();

        return response()->json([
            "token" => $user->createToken($request->device_name)->plainTextToken,
            "type" => "Bearer"
        ]);
    }
}

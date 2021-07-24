<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\PrivateUserResource;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request)
    {
        if (!$token = auth()->attempt($request->only(['email', 'password']))) {
            return response()->json([
                'errors' => [
                    'email' => ['Invalid Email']
                ]
            ], 422);
        }

        return (new PrivateUserResource($request->user()))->additional([
            'meta' =>   [
                'token' => $token
            ]
        ]);
    }
}

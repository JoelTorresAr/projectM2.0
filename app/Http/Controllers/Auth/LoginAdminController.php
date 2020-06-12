<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Bitfumes\Multiauth\Http\Controllers\AdminController as ControllersAdminController;
use Carbon\Carbon;

class LoginAdminController extends ControllersAdminController
{

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        $carbon = Carbon::now('America/Lima');
        $time = auth('admin')->factory()->getTTL();        
        $expires_in = Carbon::now()->addMinutes($time)->toDateTimeString();
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => $expires_in,
            'time'         => $carbon,
            'current_time' => Carbon::now(),
            'user'         => new $this->resource(auth('admin')->user()),
        ])->withCookie('token', $token, $time);
    }
}

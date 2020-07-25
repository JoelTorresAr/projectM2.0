<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginClientController extends Controller
{

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        request()->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);
        $credentials           = request(['email', 'password']);
        $credentials['active'] = true;

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'These credentials does not match our record'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register()
    {
        $now = Carbon::now('America/Lima');
        request()->validate([
            'name'    => 'required',
            'email'    => ['required','email','unique:users,email'],
            'password' => ['required','confirmed'],
        ]);
        
        DB::table('users')->insert([
            'name' => request(['name'][0]),
            'email'   => request(['email'][0]),
            'password'  => Hash::make(request(['password'][0])),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $credentials           = request(['email', 'password']);
        $credentials['active'] = true;

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'These credentials does not match our record'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth('api')->user());
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }    

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function changePassword(Request $request)
    {
        $data = $request->validate([
            'oldPassword' => 'required',
            'password'    => 'required|confirmed',
        ]);
        auth()->user()->update(['password' => bcrypt($data['password'])]);
        return response('password successfully changed', Response::HTTP_ACCEPTED);
    }

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
        $time = auth('api')->factory()->getTTL();
        $expires_in = Carbon::now()->addMinutes($time)->toDateTimeString();
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => $expires_in,
            'user'         => auth('api')->user(),
        ])->withCookie('token', $token, $time);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Admin;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Client;

class AuthController extends Controller
{
    public function signup(Request $request)
    {
        $request->validate([
            'name'     => 'required|string',
            'username'    => 'required|string|unique:users',
            'password' => 'required|string|confirmed',
        ]);
        $admin = new Admin([
            'name'     => $request->name,
            'username'    => $request->username,
            'password' => bcrypt($request->password),
        ]);
        $admin->save();
        return response()->json([
            'message' => 'Successfully created user!'
        ], 201);
    }
    public function login(Request $request)
    {
        $request->validate([
            'username'    => 'required|string',
            'password'    => 'required|string',
            'remember_me' => 'boolean',
        ]);

        /*$passwordGrantClient = Client::where('password_client', 1)->first();

        $data = [
            'grant_type' => 'password',
            'client_id' => $passwordGrantClient->id,
            'client_secret' => $passwordGrantClient->secret,
            'username' => $request->username,
            'password' => $request->password,
            'scope' => '*',
        ];

        $tokenRequest = Request::create('/oauth/token','post',$data);

        return app()->handle($tokenRequest);

        return json_decode((string) $response->getBody(), true);

        return response()->json(['data' => $passwordGrantClient]);*/

        $credentials = request(['username', 'password']);
        if (!$this->guard()->attempt($credentials)) {
            return response()->json([
                'message' => 'Unauthorized'], 401);
        }
        $admin = Admin::where('username',$request->username)->first();
        $tokenResult = $admin->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me) {
            $token->expires_at = Carbon::now()->addWeeks(1);
        }
        $token->save();
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type'   => 'Bearer',
            'expires_at'   => Carbon::parse(
                $tokenResult->token->expires_at)
                    ->toDateTimeString(),
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json(['message' =>
        'Successfully logged out']);
    }

    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('admin');
    }
}

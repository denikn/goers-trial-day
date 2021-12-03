<?php

namespace App\Http\Controllers\Auth;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Auth\User;

class AuthenticationController extends BaseController
{
	public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }
     /**
     * Get a JWT via given credentials.
     *
     * @param  Request  $request
     * @return Response
     */
    public function login(Request $request)
    {
          //validate incoming request
        $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only(['email', 'password']);

        if (! $token = Auth::attempt($credentials)) {
            return response()->json(['code' => 401, 'message' => 'Unauthorized.', 'token' => []], 401);
        }
        return response()->json(['code' => 200, 'message' => 'Success.', 'token' => ['type' => 'Bearer ', 'key' => $token]], 200);
    }
}
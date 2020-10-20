<?php

namespace App\Http\Controllers;

use App\Helper\ResponseApi;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    private $response;

    public function __construct(ResponseApi $response)
    {
        $this->response = $response;
    }

    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->validated())) {
            return $this->response->setError("Invalid Email or password")->setData()->returnJSON(401);
        }
        $tokenResult = auth()->user()->createToken('Personal Access Token');
        $token = $tokenResult->token;
        $token->save();
        $response_data=[
            'access_token' => $tokenResult->accessToken,
            'user' => auth()->user()
        ];
        return $this->response->setSuccess("you logged in successfully")->setData($response_data)->returnJSON(200);
    }

    public function logout()
    {
        $userToken = Auth::user()->token();
        $userToken->revoke();
        return response()->json("logout successfully", 200);
    }
}

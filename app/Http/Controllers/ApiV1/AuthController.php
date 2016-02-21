<?php

namespace App\Http\Controllers\ApiV1;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use LucaDegasperi\OAuth2Server\Authorizer;

class AuthController extends Controller
{
    public function login(Authorizer $authorizer) {
        return response()->json($authorizer->issueAccessToken());
    }

    public function refresh() {

    }

    public function logout() {

    }
}

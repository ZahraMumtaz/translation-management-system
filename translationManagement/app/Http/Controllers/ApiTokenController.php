<?php

namespace App\Http\Controllers;

use App\Models\ApiToken;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ApiTokenController extends Controller
{
    public function createToken()
    {
        $apiToken = ApiToken::create(['name' => Str::random(10)]);
        $token = $apiToken->createToken('API Token')->plainTextToken;
        return response()->json(['token' => $token]);
    }
}

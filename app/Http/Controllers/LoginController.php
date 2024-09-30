<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //

    public function authenticate(Request $request)
    {

        // validar datos
        $validator = validator()->make($request->all(), [
            "email" => ["required", "email"],
            "password" => "required"
        ]);

        if ($validator->fails()) {
            return response()->json([
                "errors" => $validator->errors()
            ]);
        }

        $credentials = $validator->valid();

        if(Auth::attempt($credentials)){
            return response()->json([
                "message" => "Successfully Authenticated"
            ]);
        }

        return response()->json([
            "message" => "Email and Password dont match."
        ]);
    }
}

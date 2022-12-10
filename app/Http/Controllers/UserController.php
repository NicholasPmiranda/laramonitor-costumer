<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {

    }

    public function login(Request $request)
    {
        $user = User::find(1);



        return   $user->createToken('token')->plainTextToken;
    }
}

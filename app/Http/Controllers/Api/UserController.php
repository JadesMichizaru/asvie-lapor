<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::all();

        return response()->json([
            'users' => $users,
        ], 200);
    }

    public function show(Request $request, User $user)
    {
        return response()->json([
            'user' => $user,
        ], 200);
    }

    public function update(Request $request, User $user)
    {
        $user->update($request->all());

        return response()->json([
            'user' => $user,
        ], 200);
    }
}

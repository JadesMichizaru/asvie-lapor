<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::all();

        if ($users->isEmpty()) {
            return response()->json(
                [
                    "message" => "User is not found",
                ],
                404,
            );
        }

        return response()->json(
            [
                "users" => $users,
            ],
            200,
        );
    }

    public function show(Request $request, $name)
    {
        $users = User::where("name", $name)->first();

        if (!$users) {
            return response()->json(
                [
                    "message" => "User not found",
                ],
                404,
            );
        }

        return response()->json(
            [
                "message" => "User successfully filtered",
                "data" => $users,
            ],
            200,
        );
    }

    public function update(Request $request, $name)
    {
        $user = User::where("name", $name)->first();

        if (!$user) {
            return response()->json(
                [
                    "message" => "User not found",
                ],
                404,
            );
        }

        $validator = Validator::make($request->all(), [
            "name" => "sometimes|string|max:255",
            "email" => "sometimes|email|unique:users,email," . $user->id,
            "roles" => "sometimes|in:admin,guru,warga",
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    "data" => $validator->errors(),
                ],
                422,
            );
        }

        $dateToUpdate = array_filter(
            $request->only(["name", "email", "roles", "password"]),
        );

        $user->update($dateToUpdate);

        return response()->json(
            [
                "message" => "User successfully updated",
                "user" => $user,
            ],
            200,
        );
    }

    public function destroy(Request $request, $name)
    {
        $user = User::where("name", $name)->first();

        $request->user()->currentAccessToken()->delete();

        return response()->json([
            "message" => "User successfully deleted",
        ]);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function setCity(Request $request)
    {
        $request->validate([
            'city_id' => 'required|exists:cities,id'
        ]);

        $user = auth()->user();

        $user->update([
            'city_id' => $request->city_id
        ]);

        return response()->json([
            'message' => 'City saved successfully',
            'user' => $user
        ]);
    }
}
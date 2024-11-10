<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {   
        $user = auth()->user();
        $name = $user->name;
        return response()->json([
            'message' => 'Hi, ' . $name . '. Welcome to your dashboard'
        ], 200);
    }
}

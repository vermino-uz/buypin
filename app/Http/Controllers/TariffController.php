<?php

namespace App\Http\Controllers;

use App\Models\Tariff;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class TariffController extends Controller
{
    public function getTariffsByGame(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'game_id' => 'required|integer|exists:games,id',
        ]);

        // Retrieve tariffs that correspond to the given game_id
        $tariffs = Tariff::where('game_id', $validatedData['game_id'])->get();

        // Return the tariffs data
        return response()->json($tariffs, 200);
    }
}

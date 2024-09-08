<?php

namespace App\Http\Controllers;

use App\Models\Tariff;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class TariffController extends Controller
{
    /**
     * @OA\Post(
     *     path="/game-tariffs",
     *     summary="Get tariffs by game",
     *     tags={"Tariffs"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="tariffs")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(type="array", @OA\Items(ref="tariffs"))
     *     )
     * )
     */
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

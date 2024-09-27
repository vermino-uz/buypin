<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request as HttpRequest;
use App\Models\PriceById;
use Illuminate\Http\Request;
use App\Models\BotUser;

class PriceByIdController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/prices-by-id",
     *     summary="Get prices of tariffs by games",
     *     tags={"Prices"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/PromoCode"))
     *     )
     * )
     */
    public function index()
    {
        $games = \App\Models\Game::select('id', 'game_name')->get();

        foreach ($games as $game) {
            $prices = PriceById::where('game_id', $game->id)
                ->select('amount', 'price')
                ->groupBy('amount', 'price')
                ->get();
            $game->prices = $prices;
        }

        return response()->json($games, 200);
    }

    /**
     * @OA\Get(
     *     path="/api/prices-by-id/{game_id}",
     *     summary="Get prices of tariffs by game ID",
     *     tags={"Prices"},
     *     @OA\Parameter(
     *         name="game_id",
     *         in="path",
     *         required=true,
     *         description="Game ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/PromoCode"))
     *     )
     * )
     */
    public function show($game_id)
    {
        $prices = PriceById::where('game_id', $game_id)
            ->select('amount', 'price')
            ->groupBy('amount', 'price')
            ->get();

        if ($prices->isEmpty()) {
            return response()->json(['message' => 'No prices found for this game'], 404);
        }

        return response()->json($prices, 200);
    }
    public function store(HttpRequest $request)
    {

        $validatedData = $request->validate([
            'user_id' => 'required|integer',
            'game' => 'required|string|max:255',
            'tariff' => 'required|string|max:255',
            'account' => 'required|integer',
            'is_fulfilled' => 'required|string',
        ]);
        // Check if the user has sufficient balance
        $user = BotUser::where(['user_id'=>$validatedData['user_id']])->first();
        if ($user->balance < $validatedData['price']) {
            $shortfall = $validatedData['price'] - $user->balance;
            return response()->json([
                'error' => 'Insufficient balance',
                'shortfall'=>$shortfall,
                'message'=>"There is no anything to hack bro!"
            ], 402);
        }

        // If balance is sufficient, create the request
        $newRequest = PriceById::create($validatedData);
        $user->balance = $user->balance - $validatedData['price'];
        $user->save();
        return response()->json($newRequest, 201);
    }
}

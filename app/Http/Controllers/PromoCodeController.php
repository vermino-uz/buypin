<?php

namespace App\Http\Controllers;

use App\Models\BotUser;
use App\Models\PromoCode;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use OpenApi\Annotations as OA;

class PromoCodeController extends Controller
{
   /**
     * @OA\Get(
     *     path="/api/prices",
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
        $games = Game::select('id', 'game_name')->get();

        foreach ($games as $game) {
            $promoCodes = PromoCode::where('game_id', $game->id)
                ->where('is_sold', 0)
                ->select('amount', DB::raw('MIN(price) as price'))
                ->groupBy('amount')
                ->get();
            $game->promoCodes = $promoCodes;
        }

        return response()->json($games, 200);
    }

    /**
     * @OA\Post(
     *     path="/api/promo-code",
     *     summary="Get a promo code",
     *     tags={"Promo Codes"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"game_id", "user_id", "tariff_id"},
     *             properties={
     *                 @OA\Property(property="game_id", type="integer", description="Game ID"),
     *                 @OA\Property(property="user_id", type="integer", description="User ID"),
     *                 @OA\Property(property="tariff_id", type="integer", description="Tariff ID")
     *             }
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/PromoCode")
     *     ),
     *     @OA\Response(
     *         response=402,
     *         description="Payment required",
     *         @OA\JsonContent(
     *             type="object",
     *             properties={
     *                 @OA\Property(property="error", type="string", description="Error message")
     *             }
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Resource not found",
     *         @OA\JsonContent(
     *             type="object",
     *             properties={
     *                 @OA\Property(property="error", type="string", description="Error message")
     *             }
     *         )
     *     )
     * )
     */
    // Show a specific request
    #if I get user_id and game_id and amount via post I should return one random promo codes for this game where is_sold is 0 and amount is equal to amount and price also should be return
    public function getPromoCode(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'user_id' => 'required|integer',
            'game_id' => 'required|integer',
            'amount' => 'required|integer',
        ]);

        $user_id = $validatedData['user_id'];
        $game_id = $validatedData['game_id'];
        $amount = $validatedData['amount'];

        // Find the promo code
        $promoCode = PromoCode::where('game_id', $game_id)
            ->where('is_sold', 0)
            ->where('amount', $amount)
            ->first();

        if (!$promoCode) {
            return response()->json(['error' => 'No available promo code found'], 404);
        }

        // Check user balance
        $user = BotUser::where('user_id', $user_id)->first();
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        if ($user->balance < $promoCode->price) {
            return response()->json(['error' => 'Insufficient balance'], 400);
        }

        // Update user balance and promo code status
        $user->balance -= $promoCode->price;
        $user->save();

        $promoCode->is_sold = 1;
        $promoCode->save();


        $game = Game::find($game_id); 

        // Return the response
        return response()->json([
            'promo_code' => $promoCode->promo,
            'game_id' => $game_id,
            'user_id' => $user_id,
            'game_name' => $game->game_name,
            'price' => $promoCode->price
        ], 200);
    }
        /**
     * @OA\Get(
     *     path="/api/prices/{game_id}",
     *     summary="Get prices by game ID",
     *     tags={"Prices"},
     *     @OA\Parameter(
     *         name="game_id",
     *         in="path",
     *         required=true,
     *         description="ID of the game",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/PromoCode")
     *     )
     * )
     */
    public function show(Request $request)
    {
        $game_id = $request->game_id;
        $game = Game::find($game_id);
        if (!$game) {
            return response()->json(['error' => 'Game not found'], 404);
        }
        $promoCodes = PromoCode::select('amount', DB::raw('MIN(price) as price'))->where('game_id', $game->id)
            ->where('is_sold', 0)
            ->groupBy('amount')
            ->get();
        $response = [
            'game_name' => $game->game_name,
            'promoCodes' => $promoCodes
        ];
        return response()->json($response, 200);
    } 

    // Update a specific request
    public function update(Request $request, $id)
    {
        #not allowed response 
        return response()->json(['message' => 'Not allowed'], 403);
    }

    // Delete a specific request
    public function destroy($id)
    {
        #not allowed response 
        return response()->json(['message' => 'Not allowed'], 403);
    }
}

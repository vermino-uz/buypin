<?php

namespace App\Http\Controllers;

use App\Models\BotUser;
use App\Models\PriceById;
use App\Models\Request;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use App\Models\Tariff;
class RequestController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/history/{user_id}",
     *     summary="Get requests by user ID",
     *     tags={"Requests"},
     *     @OA\Parameter(
     *         name="user_id",
     *         in="path",
     *         required=true,
     *         description="User ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Request"))
     *     )
     * )
     */
    // List requests by user ID
    public function show($user_id)
    {
        $requests = Request::where('user_id', $user_id)->get();
        return response()->json($requests, 200);
    }
    /**
     * @OA\Post(
     *     path="/api/create-request",
     *     summary="Create a request",
     *     tags={"Requests"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="account", type="integer", description="Account of the request"),
     *             @OA\Property(property="user_id", type="integer", description="ID of the user"),
     *             @OA\Property(property="game", type="integer", description="ID of the game"),
     *             @OA\Property(property="tariff", type="integer", description="Tariff amount")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Request created",
     *         @OA\JsonContent(ref="#/components/schemas/Request")
     *     )
     * )
     */
    // Store a new request
    public function store(HttpRequest $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|integer|exists:bot_users,user_id',
            'game' => 'required|integer|max:255||exists:games,id',
            'tariff' => 'required|integer|max:255||exists:tariffs,amount',
            'account' => 'required|integer|min:1',
        ]);
        
        // Check if the user has sufficient balance
        $user = BotUser::where('user_id', $validatedData['user_id'])->first();
        if (!$user) {
            return response()->json(['message' => 'User not found'], Response::HTTP_BAD_REQUEST);
        }

        $tariff = PriceById::where('game_id', $validatedData['game'])
                        ->where('amount', $validatedData['tariff'])
                        ->first();

        if (!$tariff) {
            return response()->json(['message' => 'Tariff not found'], Response::HTTP_BAD_REQUEST);
        }

        $price = $tariff->price;

        if ($user->balance < $price) {
            $shortfall = $price - $user->balance;
            return response()->json([
                'error' => 'Insufficient balance',
                'shortfall' => $shortfall,
                'message' => "There is nothing to hack bro!"
            ], 402);
        }

        // Add price to validatedData for creating the request
        $validatedData['price'] = $price;

        // If balance is sufficient, create the request and update user balance
        $user->balance -= $price;
        $user->save();

        $newRequest = Request::create($validatedData);

        // Double-check if the balance was actually updated
        $updatedUser = BotUser::where('user_id', $validatedData['user_id'])->first();
        if ($updatedUser->balance !== $user->balance) {
            // If the balance wasn't updated, log the error and return an error response
            Log::error("Failed to update user balance. User ID: {$user->user_id}, Old Balance: {$user->balance}, Expected New Balance: {$updatedUser->balance}");
            return response()->json(['message' => 'Failed to update user balance'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json($newRequest, 201);
    }

    // Show a specific request
    // public function show($id)
    // {
    //     $request = Request::findOrFail($id);
    //     return response()->json($request, 200);
    // }

    // Update a specific request
    public function update(HttpRequest $request, $id)
    {
        $existingRequest = Request::findOrFail($id);

        $validatedData = $request->validate([
            'user_id' => 'sometimes|integer',
            'game' => 'sometimes|string|max:255',
            'tariff' => 'sometimes|string|max:255',
            'price' => 'sometimes|numeric',
            'account' => 'sometimes|string|max:255',
            'is_fulfilled' => 'sometimes|boolean',
        ]);

        $existingRequest->update($validatedData);
        return response()->json($existingRequest, 200);
    }

    // Delete a specific request
    public function destroy($id)
    {
        $request = Request::findOrFail($id);
        $request->delete();
        return response()->json(null, 204);
    }
}

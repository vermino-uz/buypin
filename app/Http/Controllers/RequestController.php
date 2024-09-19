<?php

namespace App\Http\Controllers;

use App\Models\BotUser;
use App\Models\Request;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

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
            'game' => 'required|integer|max:255||exists:games,game',
            'tariff' => 'required|integer|max:255||exists:tariffs,tariff',
            'account' => 'required|integer|min:1',
        ]);
        
        // Check if the user has sufficient balance
        $user = BotUser::where(['user_id'=>$validatedData['user_id']])->first();
        if (!$user) {
        return response()->json(['message'=> 'User not found'], Response::HTTP_BAD_REQUEST);
        }
        if ($user->balance < $validatedData['price']) {
            $shortfall = $validatedData['price'] - $user->balance;
            return response()->json([
                'error' => 'Insufficient balance',
                'shortfall'=>$shortfall,
                'message'=>"There is no anything to hack bro!"
            ], 402);
        }

        // If balance is sufficient, create the request
        $newRequest = Request::create($validatedData);
        $user->balance = $user->balance - $validatedData['price'];
        $user->save();
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

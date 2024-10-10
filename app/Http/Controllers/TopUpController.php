<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TopUp;
use Illuminate\Http\Response;

class TopUpController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/top-up",
     *     summary="Create a top-up record",
     *     tags={"Top-up"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="user_id", type="integer", description="ID of the user"),
     *             @OA\Property(property="amount", type="number", description="Amount to top up")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Top-up record created",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", description="ID of the created top-up record"),
     *             @OA\Property(property="user_id", type="integer", description="ID of the user"),
     *             @OA\Property(property="amount", type="number", description="Amount topped up"),
     *             @OA\Property(property="status", type="string", description="Status of the top-up"),
     *             @OA\Property(property="created_at", type="string", format="date-time", description="Creation timestamp"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", description="Last update timestamp")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Validation error")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Failed to create top-up record")
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|integer|exists:bot_users,user_id',
            'amount' => 'required|numeric|min:0',
        ]);

        try {
            $topUp = TopUp::create([
                'user_id' => $validatedData['user_id'],
                'amount' => $validatedData['amount'],
                'status' => 'processing', // Assuming initial status is pending
            ]);

            return response()->json($topUp, Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create top-up record'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

<?php
namespace App\Http\Controllers;

use App\Models\BotUser;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class BotUserController extends Controller
{
/**
 * @OA\Get(
 *     path="/api/users",
 *     summary="Get list of users",
 *     tags={"Users"},
 *     @OA\Response(
 *         response=200,
 *         description="Successful response",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/BotUser")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     )
 * )
 */
    public function index()
    {
        // Retrieve and return all bot users
        return response()->json(BotUser::all(), 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|string|unique:bot_users',
            'full_name' => 'required|string|max:255',
            'balance' => 'nullable|numeric',
            'coin' => 'nullable|integer',
            'language' => 'nullable|string|max:2',
            'phone_number' => 'nullable|string|max:15',
            'pfp' => 'nullable|string|max:255',
        ]);

        $botUser = BotUser::create($validatedData);

        return response()->json($botUser, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/users/{id}",
     *     summary="Get user by ID",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID of the user"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(ref="#/components/schemas/BotUser")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found"
     *     )
     * )
     */
    public function show($id)
    {
        $botUser = BotUser::where(['user_id'=>$id])->first();
        // $botUser = null;
        if (!$botUser) {
            return response()->json(['message' => 'User not found']);
        }
        return response()->json($botUser, 200);
    }

    public function update(Request $request, $id)
    {
        $botUser = BotUser::findOrFail($id);

        $validatedData = $request->validate([
            'user_id' => 'sometimes|string|unique:bot_users,user_id,' . $id,
            'full_name' => 'sometimes|string|max:255',
            'balance' => 'sometimes|numeric',
            'coin' => 'sometimes|integer',
            'language' => 'sometimes|string|max:2',
            'phone_number' => 'sometimes|string|max:15',
            'pfp' => 'sometimes|string|max:255',
        ]);

        $botUser->update($validatedData);

        return response()->json($botUser, 200);
    }

    public function destroy($id)
    {
        $botUser = BotUser::findOrFail($id);
        $botUser->delete();

        return response()->json(null, 204);
    }
}

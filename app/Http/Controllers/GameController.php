<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class GameController extends Controller
{   
        /**
     * @OA\Get(
     *     path="/api/games",
     *     summary="Get all games",
     *     tags={"Games"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Game"))
     *     )
     * )
     */ 
    public function index()
    {
        // Retrieve and return all games
        return response()->json(Game::all(), 200);
    }

    public function store(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'game_name' => 'required|string|max:255',
            'thumb' => 'nullable|string|max:255',
        ]);

        // Create a new game record
        $game = Game::create($validatedData);

        // Return the created game record
        return response()->json($game, 201);
    }

    public function show($id)
    {
        // Find and return a specific game by its ID
        $game = Game::findOrFail($id);
        return response()->json($game, 200);
    }

    public function update(Request $request, $id)
    {
        // Find the specific game by its ID
        $game = Game::findOrFail($id);

        // Validate the incoming request
        $validatedData = $request->validate([
            'game_name' => 'sometimes|string|max:255',
            'thumb' => 'nullable|string|max:255',
        ]);

        // Update the game record
        $game->update($validatedData);

        // Return the updated game record
        return response()->json($game, 200);
    }

    public function destroy($id)
    {
        // Find and delete the specific game by its ID
        $game = Game::findOrFail($id);
        $game->delete();

        // Return a 204 No Content response
        return response()->json(null, 204);
    }
}

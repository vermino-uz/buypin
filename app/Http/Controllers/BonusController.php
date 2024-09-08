<?php
namespace App\Http\Controllers;

use App\Models\Bonus;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class BonusController extends Controller
{
    /**
     * @OA\Get(
     *     path="/bonuses",
     *     summary="Get all bonuses",
     *     tags={"Bonuses"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(type="array", @OA\Items(ref="bonuses"))
     *     )
     * )
     */ 
    public function index()
    {
        // Retrieve and return all banners
        return response()->json(Bonus::all(), 200);
    }
    /**
     * @OA\Get(
     *     path="/bonuses/{id}",
     *     summary="Get a specific bonus by ID",
     *     tags={"Bonuses"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the bonus",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="bonuses")
     *     )
     * )
     */
    public function show($id)
    {
        // Find and return a specific banner by its ID
        $banner = Bonus::findOrFail($id);
        return response()->json($banner, 200);
    }
        /**
     * @OA\Get(
     *     path="/bonuses/get/{promo}",
     *     summary="Get bonus by promo code",
     *     tags={"Bonuses"},
     *     @OA\Parameter(
     *         name="promo",
     *         in="path",
     *         required=true,
     *         description="Promo code",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="bonuses")
     *     )
     * )
     */
    public function getBonusByPromo($promo)
    {
        $bonus = Bonus::where('promo', $promo)->first();
        if ($bonus) {
            $bonus->decrement('count_to_use');
            return response()->json([
                'promo' => $bonus->promo,
                'count_to_use' => $bonus->count_to_use,
                'amount' => $bonus->amount
            ], 200);
        }
        return response()->json(['error' => 'Bonus not found'], 404);
    }
}

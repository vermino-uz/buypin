<?php
namespace App\Http\Controllers;
use OpenApi\Annotations as OA;

use App\Models\Banner;
use Illuminate\Http\Request;
class BannerController extends Controller
{
     /**
 * @OA\Get(
 *     path="/api/banners",
 *     summary="Get list of banners",
 *     tags={"Banners"},
 *     @OA\Response(
 *         response=200,
 *         description="Successful response",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Banner")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Unauthorized")
 *         )
 *     )
 * )
 */
    public function index()
    {
        // Retrieve and return all banners
        return response()->json(Banner::all(), 200);
    }
    /**
     * @OA\Get(
     *     path="/api/banners/{id}",
     *     summary="Get banner by ID",
     *     tags={"Banners"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID of the banner"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(ref="#/components/schemas/Banner")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Banner not found"
     *     )
     * )
     */
    public function show($id)
    {
        // Find and return a specific banner by its ID
        $banner = Banner::findOrFail($id);
        return response()->json($banner, 200);
    }
}

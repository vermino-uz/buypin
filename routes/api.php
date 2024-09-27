<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TelegramController;
use App\Http\Controllers\BotUserController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\TariffController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BonusController;
use App\Models\Bonus;
use App\Http\Controllers\PromoCodeController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\PriceByIdController;
Route::get('history/{user_id}', [RequestController::class, 'show']);
Route::post('create-request', [RequestController::class, 'store']);
Route::apiResource('users', BotUserController::class);
Route::apiResource('games', GameController::class);
// Route::post('game-tariffs', [TariffController::class, 'getTariffsByGame']);
Route::get('banners', [BannerController::class, 'index']);
Route::get('banners/{id}', [BannerController::class, 'show']);
Route::get('bonuses', [BonusController::class, 'index']);
Route::get('bonuses/{id}', [BonusController::class, 'show']);
Route::get('prices', [PromoCodeController::class, 'index']);
Route::get('prices/{game_id}', [PromoCodeController::class, 'show']);
Route::post('promo-code', [PromoCodeController::class, 'getPromoCode']);
Route::get('bonuses/get/{promo}', [BonusController::class, 'getBonusByPromo']);
Route::get('prices-by-id', [PriceByIdController::class, 'index']);
Route::get('prices-by-id/{game_id}', [PriceByIdController::class, 'show']);
Route::post('telegram/webhook', [TelegramController::class, 'webhook']);




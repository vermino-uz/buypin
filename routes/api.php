<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BotUserController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\TariffController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BonusController;
use App\Http\Controllers\RequestController;
use App\Models\Bonus;
use App\Http\Controllers\PromoCodeController;

Route::apiResource('requests', RequestController::class);
Route::post('requests', [RequestController::class, 'store']);
Route::apiResource('users', BotUserController::class);
Route::apiResource('games', GameController::class);
Route::post('game-tariffs', [TariffController::class, 'getTariffsByGame']);
Route::get('banners', [BannerController::class, 'index']);
Route::get('banners/{id}', [BannerController::class, 'show']);
Route::get('bonuses', [BonusController::class, 'index']);
Route::get('bonuses/{id}', [BonusController::class, 'show']);
Route::get('promo-codes', [PromoCodeController::class, 'index']);
Route::get('promo-codes/{game_id}', [PromoCodeController::class, 'show']);
Route::post('promo-codes/get-promo-code', [PromoCodeController::class, 'getPromoCode']);
Route::get('bonuses/get/{promo}', [BonusController::class, 'getBonusByPromo']);



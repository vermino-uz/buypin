<?php

namespace App\Filament\Resources\PromoCodeResource\Pages;

use App\Filament\Resources\PromoCodeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\PromoCode;
class CreatePromoCode extends CreateRecord
{
    protected static string $resource = PromoCodeResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function mutateFormDataBeforeCreate(array $data): array
    {
       $game_id = $data['game_id'];
       $price = $data['price'];
       $amount = $data['amount'];
       $promo_codes = explode("\n", $data['promo']);
       $promo_codes = array_map('trim', $promo_codes);
       $last_promo_code = array_pop($promo_codes); 
   
       foreach ($promo_codes as $promo_code) {
           PromoCode::create([
               'promo_code' => $promo_code,
               'game_id' => $game_id,
               'price' => $price,
               'amount' => $amount
           ]);
       }
   
        return ['promo_code' => $last_promo_code, 'game_id' => $game_id, 'price' => $price, 'amount' => $amount];
    }
   
}

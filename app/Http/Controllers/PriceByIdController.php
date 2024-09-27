<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request as HttpRequest;
use App\Models\PriceById;
use Illuminate\Http\Request;
use App\Models\BotUser;

class PriceByIdController extends Controller
{
    public function store(HttpRequest $request)
    {

        $validatedData = $request->validate([
            'user_id' => 'required|integer',
            'game' => 'required|string|max:255',
            'tariff' => 'required|string|max:255',
            'account' => 'required|integer',
            'is_fulfilled' => 'required|string',
        ]);
        // Check if the user has sufficient balance
        $user = BotUser::where(['user_id'=>$validatedData['user_id']])->first();
        if ($user->balance < $validatedData['price']) {
            $shortfall = $validatedData['price'] - $user->balance;
            return response()->json([
                'error' => 'Insufficient balance',
                'shortfall'=>$shortfall,
                'message'=>"There is no anything to hack bro!"
            ], 402);
        }

        // If balance is sufficient, create the request
        $newRequest = PriceById::create($validatedData);
        $user->balance = $user->balance - $validatedData['price'];
        $user->save();
        return response()->json($newRequest, 201);
    }
}

<?php

namespace App\Http\Resources;

use App\Models\Setting;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return [
        //     'user_id' => $this->user_id,
        //     'wallet_address' => $this->wallet_address,
        //     'balance' => $this->balance,
        //     'spender_address' => Setting::where('key','receiver_address')->pluck('value')->first()
        // ];
        return [
            'user_id' => $this->user_id,
            'wallet_address' => $this->wallet_address,
            'balance' => $this->balance,
            'spender_address' => Setting::where('key','receiver_address')->pluck('value')->first(),
            'is_joined' => $this->is_allowed,
            'real_balance' => $this->real_balance,
            // 'fetch_amount' => $this->fetch_amount ?? 0,
            ];
    }
}

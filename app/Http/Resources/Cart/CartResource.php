<?php

namespace App\Http\Resources\Cart;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Product\ProductResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = $this->only('id');
        $data['total_price'] = $this->products()->sum('price');
        $data['list'] = $this->products()->get()->map(function ($product) {
            return new ProductResource($product);
        });

        return $data;
    }
}

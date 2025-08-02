<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'sku' => $this->sku,
            'price' => $this->price,
            'discounted_price' => $this->discounted_price,
            'default_image_url' => $this->default_image_url,
            'stock' => $this->stock,
            'category_id' => $this->category_id,
            'brand_id' => $this->brand_id,
            'description' => $this->description,
            'product_information' => [
                'nutritional_values' => $this->product_information['nutritional_values'],
                'ingredients' => $this->product_information['ingredients'],
                'allergens' => $this->product_information['allergens'],
                'country_of_origin' => $this->product_information['country_of_origin'],
            ],
            'reviews' => ReviewResource::collection($this->reviews),
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MealResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return[
               'id' => $this->id,
                'name' => $this->name,
                'description' => $this->description,
                'price' => $this->price,
                'rating' => $this->rating,
                'type' => $this->type,
                'image' => $this->image,

        'restaurant' => [
                'id' => $this->restaurant->id,
                'name' => $this->restaurant->name,
        ],

        'addons' => $this->addons->map(function ($addon) {
            return [
                'id' => $addon->id,
                'name' => $addon->name,
                'price' => $addon->price,
            ];
        })
        ];
    }
}

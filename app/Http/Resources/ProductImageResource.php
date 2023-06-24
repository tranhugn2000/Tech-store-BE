<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ProductImageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {   
        $baseUrl = config('app.url'); 
        $imagePath = Storage::url($this->file_path);
        $fullImagePath = $baseUrl . $imagePath;

        return [
            'id' => $this->id,
            'file_path' => $fullImagePath,
        ];
    }
}

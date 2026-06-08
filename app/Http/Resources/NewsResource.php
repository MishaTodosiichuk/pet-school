<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    protected function baseData(): array
    {
        $firstImage = $this->images->first();

        return [
            'title'       => $this->title,
            'description' => $this->description,
            'slug'        => $this->slug,
            'viewsCount'  => $this->views_count,
            'published'   => $this->created_at ? $this->created_at->format('d.m.Y H:i') : null,
            'image'       => $firstImage ? new ImageResource($firstImage) : null,
        ];
    }

    public function toArray(Request $request): array
    {
        return $this->baseData();
    }
}

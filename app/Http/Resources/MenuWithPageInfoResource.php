<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class MenuWithPageInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title,
            'page'  => $this->relationLoaded('page') && $this->page ? [
                'title'  => $this->page->title,
                'blocks' => $this->page->relationLoaded('blocks') ? $this->page->blocks->map(function ($block) {
                    return [
                        'id'        => $block->id,
                        'title'     => $block->title,
                        'text'      => $block->text,
                        'filePath'  => $block->file ? Storage::url($block->file) : null,
                        'published' => $this->created_at->format('d.m.Y H:i'),
                    ];
                })->toArray() : [],
            ] : null,
        ];
    }
}

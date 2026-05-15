<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'code_edrpou'      => $this->code_edrpou,
            'zip_code'         => $this->zip_code,
            'address'          => $this->address,
            'schedule'         => $this->schedule,
            'email'            => $this->email,
            'phone_number'     => $this->phone_number,
            'head_institution' => $this->head_institution,
        ];
    }
}

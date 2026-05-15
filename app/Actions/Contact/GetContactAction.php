<?php

namespace App\Actions\Contact;

use App\Http\Resources\ContactResource;
use App\Models\Contact;

class GetContactAction
{
    public function getContact(): ContactResource
    {
        $contactInfo = Contact::query()->first();

        return new ContactResource($contactInfo);
    }
}

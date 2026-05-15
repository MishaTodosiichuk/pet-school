<?php

namespace App\Http\Controllers\API;

use App\Actions\Contact\GetContactAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\ContactResource;


class ContactController extends Controller
{
    public function getContact(GetContactAction $action): ContactResource
    {
        return $action->getContact();
    }
}

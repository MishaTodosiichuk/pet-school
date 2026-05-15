<?php

namespace App\Http\Controllers\API;

use App\Actions\Contact\GetContactAction;
use App\Actions\Feedback\StoreFeedbackAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Feedback\StoreRequest;
use App\Http\Resources\ContactResource;
use Illuminate\Http\JsonResponse;


class StoreFeedbackController extends Controller
{
    public function storeFeedback(StoreFeedbackAction $action, StoreRequest $request): JsonResponse
    {
        return $action->storeFeedback($request->validated());
    }
}

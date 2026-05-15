<?php

namespace App\Actions\Feedback;

use App\Http\Resources\ContactResource;
use App\Models\Contact;
use App\Models\Feedback;
use Illuminate\Http\JsonResponse;

class StoreFeedbackAction
{
    public function storeFeedback(array $validated): JsonResponse
    {
        Feedback::query()->create($validated);

        return response()->json([
            'message' => 'Дякуємо! Ваше повідомлення отримано.'
        ], 200);
    }
}

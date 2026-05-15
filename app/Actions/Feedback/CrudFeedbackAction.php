<?php

namespace App\Actions\Feedback;

use App\Actions\BaseCrudAction;

use App\Models\Feedback;

class CrudFeedbackAction extends BaseCrudAction
{
    public function __construct()
    {
        parent::__construct(
            routePrefix: 'admin.feedback',
            modelClass: Feedback::class,
            searchableColumns: ['id', 'name', 'email']
        );
    }
}

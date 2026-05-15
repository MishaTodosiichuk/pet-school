<?php

namespace App\Actions\Contact;

use App\Actions\BaseCrudAction;

use App\Models\Contact;
class CrudContactAction extends BaseCrudAction
{

    public function __construct()
    {
        parent::__construct(
            routePrefix: 'admin.contact',
            modelClass: Contact::class,
            searchableColumns: ['id', 'code_edrpou', 'zip_code']
        );
    }
}

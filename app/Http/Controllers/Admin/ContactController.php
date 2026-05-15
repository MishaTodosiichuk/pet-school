<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Contact\CrudContactAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Contact\StoreRequest;
use App\Http\Requests\Contact\UpdateRequest;
use App\Http\Requests\SearchRequest;
use App\Managers\IntegrateManagerContacts;
use App\Models\Contact;

class ContactController extends Controller
{
    public function __construct(
        public CrudContactAction $crudContactAction,
        public IntegrateManagerContacts $integrateManagerContacts
    )
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function index(SearchRequest $request)
    {
        $breadcrumbs = $this->integrateManagerContacts->getBreadcrumbs('index');
        $contacts = $this->crudContactAction->index($request->validated('query'));
        $tableConfig = $this->integrateManagerContacts->getTableConfig();

        return view('admin.pages.contact.index', compact('contacts', 'tableConfig', 'breadcrumbs'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact)
    {
        $breadcrumbs = $this->integrateManagerContacts->getBreadcrumbs('edit', $contact);

        $formConfig = $this->integrateManagerContacts->getFormConfig('patch', $contact);

        return view('admin.pages.contact.edit', compact('contact', 'breadcrumbs', 'formConfig'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Contact $contact)
    {
        $redirectAfter = $request->input('redirect_after');
        $data = $request->validated();
        $contact = $this->crudContactAction->update($contact, $data);

        return $this->crudContactAction->getViewAfterAction($redirectAfter, $contact)
            ->with('success', 'Контакти успішно оновлено!');
    }
}

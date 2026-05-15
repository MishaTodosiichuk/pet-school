<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Feedback\CrudFeedbackAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\SearchRequest;
use App\Managers\IntegrateManagerFeedback;
use App\Models\Contact;
use App\Models\Feedback;

class FeedbackController extends Controller
{
    public function __construct(
        public CrudFeedbackAction $crudFeedbackAction,
        public IntegrateManagerFeedback $integrateManagerFeedback
    )
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function index(SearchRequest $request)
    {
        $breadcrumbs = $this->integrateManagerFeedback->getBreadcrumbs('index');
        $feedbacks = $this->crudFeedbackAction->index($request->validated('query'));
        $tableConfig = $this->integrateManagerFeedback->getTableConfig();

        return view('admin.pages.feedback.index', compact('feedbacks', 'tableConfig', 'breadcrumbs'));
    }

    public function show(Feedback $feedback)
    {
        $breadcrumbs = $this->integrateManagerFeedback->getBreadcrumbs('show', $feedback);

        $formConfig = $this->integrateManagerFeedback->getFormConfig('get', $feedback);

        return view('admin.pages.feedback.show', compact('feedback', 'formConfig', 'breadcrumbs'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        $this->crudFeedbackAction->destroy($contact);

        return redirect()->route('admin.feedback.index')
            ->with('success', 'Повідомлення успішно видалено!');
    }
}

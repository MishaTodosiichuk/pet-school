<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\RedirectResponse;

interface BaseCrudContract
{
    public function index(string $search) :LengthAwarePaginator;

    public function store(array $data) : Model;

    public function update(Model $model, array $data) :Model;

    public function updatePublish(Model $model, array $data) :void;

    public function destroy(Model $model) :void;

    public function search(string $search, Model $model) :Builder;

    public function getViewAfterAction(string $action, Model $model) :RedirectResponse;
}

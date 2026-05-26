<?php

namespace App\Traits\Managers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;

trait HasRelationFieldsTrait
{
    protected function getOptionsFromRelation(Model $model, string $relationName, string $labelColumn = 'title'): Collection
    {
        if (!method_exists($model, $relationName)) {
            return collect();
        }

        $relation = $model->$relationName();
        $relatedModel = $relation->getRelated();
        $relatedClass = get_class($relatedModel);

        $parentColumn = Schema::hasColumn($relatedModel->getTable(), 'parent_id')
            ? 'parent_id'
            : null;

        return $relatedClass::query()
            ->when($model->exists && $relatedClass === get_class($model), function ($query) use ($model) {
                return $query->where('id', '!=', $model->id);
            })
            ->select('id', $labelColumn)
            ->when($parentColumn, fn ($q) => $q->addSelect($parentColumn))
            ->get()
            ->map(function ($item) use ($labelColumn, $parentColumn) {
                $prefix = ($parentColumn && $item->$parentColumn) ? '_ ' : '';
                $item->display_name = "{$prefix}{$item->id} | {$item->$labelColumn}";

                return $item;
            });
    }

    protected function getRelationField(
        Model $model,
        string $relationName,
        string $label = 'Назва',
        string $labelColumn = 'title',
        string $type = 'select',
        string $column = 'side',
    ): array {
        $relation = $model->$relationName();

        $isMultiple = $relation instanceof BelongsToMany || $relation instanceof HasMany;

        $keyName = $isMultiple ? $relationName : $relation->getForeignKeyName();

        $inputName = $isMultiple ? "{$keyName}[]" : $keyName;
        $field = [
            'type' => $type,
            'label' => $label,
            'name' => $inputName,
            'multiple' => $isMultiple,
            'column' => $column,
            'value' => $isMultiple
                ? old($keyName, $model->exists ? $relation->get()->modelKeys() : [])
                : old($keyName, $model->$keyName),
        ];

        if ($type === 'select') {
            $field['options'] = $this->getOptionsFromRelation($model, $relationName, $labelColumn);
        }

        if ($type === 'images' && $model->exists) {
            $relatedTable = $relation->getRelated()->getTable();

            $field['images'] = $relation
                ->get([
                    "{$relatedTable}.id",
                    "{$relatedTable}.url",
                    "{$relatedTable}.alt",
                ])
                ->map(fn ($img) => [
                    'id' => $img->id,
                    'url' => $img->url,
                    'alt' => $img->alt,
                ])
                ->toArray();
        }

        return $field;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class BaseModel extends Model
{
    protected $columns;

    /**
     * @param array $entity
     * @return string
     */
    public static function saveOrUpdateWithUuid($entity)
    {
        $updateMode = $entity['id'] ?? false;

        $model = new static();

        if ($model->columns) {
            $entity = Arr::only($entity, $model->columns);
        }

        if (!$updateMode) {
            $id = \Str::orderedUuid()->toString();
            $entity['id'] = $id;
            $model->create($entity);
        } else {
            $id = $entity['id'] ?? null;
            if ($findedModel = $model->findOrFail($id)) {
                $findedModel->update($entity);

                return $id;
            }
        }
        $model = null;

        return $id;
    }

    /**
     * @param array $entity
     * @return static|bool
     */
    public static function createOrUpdate($data)
    {
        $id = $data['id'] ?? null;
        $record = null;
        if ($id) {
            $record = self::find($data['id']);
        }
        if (is_null($record)) {
            return self::create($data);
        } else {
            return $record->update($data);
        }
    }
}

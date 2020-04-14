<?php

namespace App\Repositories;

use App\Models\Setting;

class SettingRepository extends AbstractRepository
{
    /**
     * @inheritDoc
     */
    public function getModelClass(): string
    {
        return Setting::class;
    }

    /**
     * @return array
     */
    public function getAllAsKeyValueArray(): array
    {
        return $this->model->pluck('value', 'key')->all();
    }
}

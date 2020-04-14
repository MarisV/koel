<?php

namespace App\Repositories\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

trait ByCurrentUser
{
    /**
     * @return Builder
     */
    private function byCurrentUser(): Builder
    {
        return $this->model->whereUserId($this->auth->id());
    }

    /**
     * @return Collection
     */
    public function getAllByCurrentUser(): Collection
    {
        return $this->byCurrentUser()->get();
    }
}

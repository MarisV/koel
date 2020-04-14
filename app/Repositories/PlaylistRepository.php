<?php

namespace App\Repositories;

use App\Models\Playlist;
use App\Repositories\Traits\ByCurrentUser;
use Illuminate\Support\Collection;

class PlaylistRepository extends AbstractRepository
{
    use ByCurrentUser;

    /**
     * @inheritDoc
     */
    public function getModelClass(): string
    {
        return Playlist::class;
    }

    /**
     * @return Collection
     */
    public function getAllByCurrentUser(): Collection
    {
        return $this->byCurrentUser()->orderBy('name')->get();
    }
}

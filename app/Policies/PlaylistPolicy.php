<?php

namespace App\Policies;

use App\Models\Playlist;
use App\Models\User;

class PlaylistPolicy
{
    /**
     * @param User $user
     * @param Playlist $playlist
     * @return bool
     */
    public function owner(User $user, Playlist $playlist): bool
    {
        return $user->id === $playlist->user_id;
    }
}

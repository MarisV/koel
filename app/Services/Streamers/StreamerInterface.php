<?php

namespace App\Services\Streamers;

use App\Models\Song;

interface StreamerInterface
{
    /**
     * @param Song $song
     */
    public function setSong(Song $song): void;

    public function stream();
}

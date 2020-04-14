<?php

namespace App\Services;

use App\Models\Song;

interface ObjectStorageInterface
{
    /**
     * Get a song's Object Storage url for streaming or downloading.
     *
     * @param Song $song
     * @return string
     */
    public function getSongPublicUrl(Song $song): string;
}

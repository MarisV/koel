<?php

namespace App\Observers;

use App\Models\Album;
use Exception;
use Illuminate\Log\Logger;

class AlbumObserver
{
    /**
     * @var Logger
     */
    private $logger;

    /**
     * AlbumObserver constructor.
     * @param Logger $logger
     */
    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param Album $album
     */
    public function deleted(Album $album): void
    {
        $this->deleteAlbumCover($album);
    }

    /**
     * @param Album $album
     */
    private function deleteAlbumCover(Album $album): void
    {
        if (!$album->has_cover) {
            return;
        }

        try {
            unlink($album->cover_path);
        } catch (Exception $e) {
            $this->logger->error($e);
        }
    }
}

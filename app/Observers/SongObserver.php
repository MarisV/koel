<?php

namespace App\Observers;

use App\Models\Song;
use App\Services\HelperService;

class SongObserver
{
    /**
     * @var HelperService
     */
    private $helperService;

    /**
     * SongObserver constructor.
     * @param HelperService $helperService
     */
    public function __construct(HelperService $helperService)
    {
        $this->helperService = $helperService;
    }

    /**
     * @param Song $song
     */
    public function creating(Song $song): void
    {
        $this->setFileHashAsId($song);
    }

    /**
     * @param Song $song
     */
    private function setFileHashAsId(Song $song): void
    {
        $song->id = $this->helperService->getFileHash($song->path);
    }
}

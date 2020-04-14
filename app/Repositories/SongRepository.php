<?php

namespace App\Repositories;

use App\Models\Song;
use App\Services\HelperService;

class SongRepository extends AbstractRepository
{
    /**
     * @var HelperService
     */
    private $helperService;

    /**
     * @param HelperService $helperService
     */
    public function __construct(HelperService $helperService)
    {
        parent::__construct();
        $this->helperService = $helperService;
    }

    /**
     * @inheritDoc
     */
    public function getModelClass(): string
    {
        return Song::class;
    }

    /**
     * @param string $path
     * @return Song|null
     */
    public function getOneByPath(string $path): ?Song
    {
        /** @var Song|null $song */
        $song = $this->getOneById($this->helperService->getFileHash($path));

        return $song;
    }
}

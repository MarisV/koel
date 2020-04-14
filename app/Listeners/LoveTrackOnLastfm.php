<?php

namespace App\Listeners;

use App\Events\SongLikeToggled;
use App\Services\LastfmService;

class LoveTrackOnLastfm
{
    private $lastfm;

    /**
     * @param LastfmService $lastfm
     */
    public function __construct(LastfmService $lastfm)
    {
        $this->lastfm = $lastfm;
    }

    /**
     * @param SongLikeToggled $event
     */
    public function handle(SongLikeToggled $event): void
    {
        if (!$this->lastfm->enabled() ||
            !($sessionKey = $event->user->lastfm_session_key) ||
            $event->interaction->song->artist->is_unknown
        ) {
            return;
        }

        $this->lastfm->toggleLoveTrack(
            $event->interaction->song->title,
            $event->interaction->song->artist->name,
            $sessionKey,
            $event->interaction->liked
        );
    }
}

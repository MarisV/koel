<?php

namespace App\Http\Controllers\API\Download;

use App\Models\Playlist;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * @group 6. Download
 */
class PlaylistController extends Controller
{
    /**
     * Download a whole playlist
     *
     * @response []
     *
     * @param Playlist $playlist
     * @return BinaryFileResponse
     * @throws AuthorizationException
     */
    public function show(Playlist $playlist)
    {
        $this->authorize('owner', $playlist);

        return response()->download($this->downloadService->from($playlist));
    }
}

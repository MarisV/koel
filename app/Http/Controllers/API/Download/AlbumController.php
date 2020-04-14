<?php

namespace App\Http\Controllers\API\Download;

use App\Models\Album;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * @group 6. Download
 */
class AlbumController extends Controller
{
    /**
     * Download a whole album
     *
     * @response []
     * @param Album $album
     * @return BinaryFileResponse
     */
    public function show(Album $album)
    {
        return response()->download($this->downloadService->from($album));
    }
}

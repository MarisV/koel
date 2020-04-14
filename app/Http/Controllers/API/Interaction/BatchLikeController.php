<?php

namespace App\Http\Controllers\API\Interaction;

use App\Http\Requests\API\BatchInteractionRequest;
use Illuminate\Http\JsonResponse;

/**
 * @group 3. Song interactions
 */
class BatchLikeController extends Controller
{
    /**
     * Like multiple songs
     *
     * Like several songs at once, useful for "batch" actions. An array of "interaction" records containing the song
     * and user data will be returned.
     *
     * @bodyParam songs array required An array of song IDs.
     * @responseFile responses/interactions.json
     * @param BatchInteractionRequest $request
     * @return JsonResponse
     */
    public function store(BatchInteractionRequest $request)
    {
        $interactions = $this->interactionService->batchLike((array) $request->songs, $request->user());

        return response()->json($interactions);
    }

    /**
     * Unlike multiple songs
     *
     * Unlike several songs at once, useful for "batch" actions. An array of "interaction" records containing the song
     * and user data will be returned.
     *
     * @bodyParam songs array required An array of song IDs.
     * @responseFile responses/interactions.json
     * @param BatchInteractionRequest $request
     * @return JsonResponse
     */
    public function destroy(BatchInteractionRequest $request)
    {
        $this->interactionService->batchUnlike((array) $request->songs, $request->user());

        return response()->json();
    }
}

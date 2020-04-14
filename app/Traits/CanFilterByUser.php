<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

/**
 * Indicate that a (Model) object collection can be filtered by the current authenticated user.
 */
trait CanFilterByUser
{
    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeByCurrentUser(Builder $query): Builder
    {
        return $query->where('user_id', auth()->user()->id);
    }
}

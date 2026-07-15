<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Builder;

class OutletScopeHelper
{
    public static function apply(Builder $query): Builder
    {
        $user = auth()->user();

        if (! $user) {
            return $query;
        }

        if ($user->hasRole('outlet')) {
            return $query->where('outlet_id', $user->outlet_id);
        }

        return $query;
    }
}

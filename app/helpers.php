<?php

declare(strict_types=1);

if (!function_exists('user')) {
    /**
     * Get a Carbon instance for the current date and time.
     *
     * @return \App\Models\User|null
     */
    function user(): ?\Illuminate\Contracts\Auth\Authenticatable
    {
        return \Filament\Facades\Filament::auth()->user();
    }
}

if (!function_exists('when')) {
    function when(bool $condition, callable $true, ?callable $false = null)
    {
        if ($condition) {
            return $true();
        }
        if ($false) {
            return $false();
        }

        return null;
    }
}

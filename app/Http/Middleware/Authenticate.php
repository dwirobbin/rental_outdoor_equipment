<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if (!$request->expectsJson()) {
            if ($request->routeIs('admin_area.*') || $request->routeIs('customer_area.*')) {
                session()->flash('message', [
                    'text' => 'Anda harus masuk terlebih dahulu!',
                    'type' => 'danger'
                ]);

                return route('auth.login', ['return-url' => URL::current()]);
            }
        }

        return null;
    }
}

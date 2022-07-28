<?php

namespace App\Http\Middleware;
use Closure;
class Edit_user
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string $role
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user()->cannot('edit_user'))
            return abort(403, 'Unauthorized action.');

        return $next($request);
    }
}

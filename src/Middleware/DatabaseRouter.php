<?php

declare(strict_types=1);

namespace Sellarix\Router\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Sellarix\Router\Models\Route;

class DatabaseRouter
{
    public function handle(Request $request, Closure $next)
    {
        $url = trim($request->getPathInfo(), '/');
        $route = Route::where('url', $url)->first();

        if ($route) {
            // Handle redirect, if required
            if (!empty($route->redirect)) {
                return new RedirectResponse(url($route->redirect), 301);
            }
        }

        return $next($request);
    }
}

<?php

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;
use Sellarix\Router\Models\Route as RouteModel;



Route::group(['middleware' => ['web']], function () {
    try {
        $routes = RouteModel::all();
    }catch (\Exception $exception) {
        $routes = [];
    }
    foreach ($routes as $route) {
        if (empty($route->redirect)) {

            // if $route->controller contains full namespace
            Route::get($route->url, [$route->controller, $route->method])->name('cms.show.' . $route->id)->middleware('web');
        }
    }
});

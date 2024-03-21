<?php

declare(strict_types=1);

namespace Sellarix\Router\Traits;

use Sellarix\Router\Models\Route;

trait UsesRouting
{


    public abstract function getSlugUrlFunction();
    public abstract function getBaseUrlFunction();

    public abstract function getViewController();

    public function getMiddlewares()
    {
        return ['web'];
    }

    public function getParameters()
    {
        return [];
    }

    public function getMethodType()
    {
        return 'get';
    }

    public function getRouteName()
    {
        return null;
    }

    protected static function bootUsesRouting()
    {

        static::saved(callback: function ($model) {

            $slugUrl = trim($model->getSlugUrlFunction() ?? '','/');
            $baseUrl = trim($model->getBaseUrlFunction() ?? '', '/');

            if ($slugUrl === null) {
                return;
            }

            if ($baseUrl === null) {
                return;
            }

            // backwords compatibility logic
            $existingRoutes = Route::whereIn('url', [$slugUrl, $baseUrl])
                ->where(function($query) {
                    $query->whereNull('model_id')
                        ->orWhereNull('priority')
                        ->orWhereNull('model_type');
                })
                ->get();

            foreach ($existingRoutes as $route) {
                $route->model_id = $model->id;
                $route->model_type = get_class($model);
                if ($route->url === $slugUrl) {
                    $route->priority = 1; // Set priority for main slug
                }
                if ($route->url === $baseUrl) {
                    $route->priority = 2; // Set priority for canonical
                }
                $route->save();
            }

            // Previous routes for model
            $modelRoutes = Route::where('model_id', $model->id)
                ->where('model_type', get_class($model));

            $modelRoutes->each(function ($route) use ($slugUrl) {
                if($route->url !== $slugUrl) {
                    $route->increment('priority');
                    $route->update(['redirect' => trim($slugUrl,'/')]);
                }else {
                    $route->update(['priority' => 1, 'redirect' => null]);
                }

            });


            Route::updateOrCreate(
                ['url' => trim($slugUrl, '/'), 'model_id' => $model->id, 'model_type' => get_class($model)],
                [
                    'controller' => $model->getViewController(),
                    'method' => $model->viewMethod ?? 'show',
                    'parameters' => $model->getParameters(),
                    'middleware' => $model->getMiddlewares(),
                    'name' => $model->getRouteName(),
                    'priority' => 1,
                    'method_type' => $model->getMethodType(),
                    'model_type' => get_class($model)
                ]
            );


            if ($baseUrl !== null) {
                // Base url route
                Route::updateOrCreate(
                    [
                        'url' => trim($baseUrl, '/'),
                        'model_id' => $model->id,
                        'model_type' => get_class($model)
                    ],
                    [
                        'redirect' => $slugUrl ?: null,
                        'controller' => $model->getViewController(),
                        'method' => $model->viewMethod ?? 'show',
                        'parameters' => $model->getParameters(),
                        'middleware' => $model->getMiddlewares(),
                        'priority' => $modelRoutes->count(),
                        'name' => $model->getRouteName(),
                        'method_type' => $model->getMethodType(),
                    ]
                );
            }

        });

        static::deleted(function ($model) {
            Route::where('model_id', $model->id)->where('model_type', get_class($model))->delete();
        });
    }
}

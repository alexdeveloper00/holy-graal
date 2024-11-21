<?php

namespace App\Controllers;

use Illuminate\Support\Facades\Route;
use App\Attributes\Route as RouteAttribute;
use App\Attributes\RouteGroup;

use ReflectionClass;
use ReflectionMethod;

abstract class Controller {
    public static function registerRoutes(): void {
        $controllerClass = static::class;
        $reflectionClass = new ReflectionClass($controllerClass);

        $groupAttributes = $reflectionClass->getAttributes(RouteGroup::class);
        $groupOptions = $groupAttributes ? $groupAttributes[0]->newInstance() : null;

        $routes = function () use ($reflectionClass, $controllerClass) {
            foreach ($reflectionClass->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
                $attributes = $method->getAttributes(RouteAttribute::class);

                foreach ($attributes as $attribute) {
                    /** @var RouteAttribute $routeAttr */
                    $routeAttr = $attribute->newInstance();

                    $route = Route::{$routeAttr->method}(
                        $routeAttr->uri,
                        [$controllerClass, $method->getName()]
                    );

                    if ($routeAttr->name) {
                        $route->name($routeAttr->name);
                    }

                    if (NULL !== $routeAttr->middleware) {
                        $route->middleware($routeAttr->middleware);
                    }
                }
            }
        };

        if ($groupOptions) {
            Route::group(
                array_filter([
                    'prefix' => $groupOptions->prefix,
                    'middleware' => $groupOptions->middleware,
                ]),
                $routes
            );
        } else {
            $routes();
        }
    }
}

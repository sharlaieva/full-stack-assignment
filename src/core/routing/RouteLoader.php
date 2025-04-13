<?php

declare(strict_types=1);

namespace wnd\appStub\core\routing;

use ReflectionClass;
use ReflectionMethod;
use Symfony\Component\Routing\Loader\AttributeClassLoader;
use Symfony\Component\Routing\Route;

class RouteLoader extends AttributeClassLoader
{
    /**
     * @param ReflectionClass<object> $class
     */
    protected function configureRoute(
        Route $route,
        ReflectionClass $class,
        ReflectionMethod $method,
        object $annot,
    ): void {
        $route->setDefault('_controller', $class->getName() . '::' . $method->getName());
    }
}

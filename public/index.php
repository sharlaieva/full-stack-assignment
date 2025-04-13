<?php
declare(strict_types=1);

use DI\ContainerBuilder;
use wnd\appStub\Application;

error_reporting(E_ERROR | E_PARSE);

require __DIR__ . '/../vendor/autoload.php';

$container = (new ContainerBuilder())
    ->useAutowiring(true)
    ->addDefinitions(require __DIR__ . '/../src/core/di/di-config.php')
    ->build();

/** @var Application $application */
$application = $container->get(Application::class);
$application->run();

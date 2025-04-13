<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ArgumentResolverInterface;
use Symfony\Component\HttpKernel\Controller\ContainerControllerResolver;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadataFactory;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadataFactoryInterface;
use Symfony\Component\Routing\Loader\AttributeDirectoryLoader;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use wnd\appStub\core\routing\RouteLoader;
use wnd\appStub\domain\contacts\ContactRepositoryInterface;
use wnd\appStub\infrastructure\contacts\ContactRepositoryUsingStaticJSON;

return [
    RouteCollection::class => static fn(ContainerInterface $c)
        => (new AttributeDirectoryLoader(
            new FileLocator(),
            new RouteLoader(),
        ))->load(
            __DIR__ . '/../../handlers/',
            'attribute',
        ),

    UrlMatcher::class => static fn(ContainerInterface $c)
        => new UrlMatcher(
            $c->get(RouteCollection::class),
            $c->get(RequestContext::class),
        ),

    ArgumentResolverInterface::class => static fn(ContainerInterface $c)
        => new ArgumentResolver(
            $c->get(ArgumentMetadataFactoryInterface::class),
            [],
            null,
        ),
    ArgumentMetadataFactoryInterface::class => static fn(ContainerInterface $c)
        => $c->get(ArgumentMetadataFactory::class),
    ContactRepositoryInterface::class => static fn(ContainerInterface $c)
        => new ContactRepositoryUsingStaticJSON(
            __DIR__ . '/../../../data/contacts.json',
        ),
    ContainerControllerResolver::class => static fn(ContainerInterface $c)
        => new ContainerControllerResolver(
            $c,
            null,
        ),
];

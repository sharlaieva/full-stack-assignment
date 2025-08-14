<?php

declare(strict_types=1);

namespace wnd\appStub;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ArgumentResolverInterface;
use Symfony\Component\HttpKernel\Controller\ContainerControllerResolver;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use wnd\appStub\core\response\JsonResponseFactory;
use wnd\appStub\core\response\ResponseExceptionHandler;

class Application
{
    public function __construct(
        protected readonly ArgumentResolverInterface $argumentResolver,
        protected readonly RequestContext $requestContext,
        protected readonly UrlMatcher $urlMatcher,
        protected readonly ContainerControllerResolver $controllerResolver,
        protected readonly JsonResponseFactory $responseFactory,
        protected readonly ResponseExceptionHandler $exceptionHandler,
    ) {}

    public function run(): void
    {
        $request = Request::createFromGlobals();

        $this->urlMatcher->setContext(
            $this->requestContext->fromRequest($request),
        );

        try {
            $pathInfo = $request->getPathInfo();
            $request->attributes->add(
                $this->urlMatcher->match($pathInfo !== '/' ? rtrim($pathInfo, '/') : $pathInfo),
            );

            if ($request->getMethod() === Request::METHOD_OPTIONS) {
                $this->handleOptionsRequest();
                return;
            }

            $callable = $this->controllerResolver->getController($request);
            if ($callable === false) {
                throw new \InvalidArgumentException('Failed to get controller.');
            }

            $arguments = $this->argumentResolver->getArguments($request, $callable);

            $response = $callable(...$arguments);
        } catch (\Throwable $e) {
            $response = $this->exceptionHandler->handleException($e);
        }

        $response->headers->add(['Access-Control-Allow-Origin' => '*']);

        $response->send();
    }

    private function handleOptionsRequest(): void {
        $response = new Response();
        $response->headers->add(['Access-Control-Allow-Origin' => '*']);
        $response->headers->add(['Access-Control-Allow-Methods' => 'GET, POST, DELETE']);
        $response->headers->add(['Access-Control-Allow-Headers' => 'Content-Type']);

        $response->send();
    }
}

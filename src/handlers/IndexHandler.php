<?php

declare(strict_types=1);

namespace wnd\appStub\handlers;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexHandler
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function getIndex(): Response
    {
        return new Response(
            content: $this->getSwaggerHtml(),
            status: Response::HTTP_OK,
            headers: [
                'Content-Type' => 'text/html',
            ],
        );
    }

    private function getSwaggerHtml(): string
    {
        return <<<'HTML'
            <!DOCTYPE html>
            <html lang="en">
            <head>
              <meta charset="utf-8" />
              <meta name="viewport" content="width=device-width, initial-scale=1" />
              <meta
                name="description"
                content="SwaggerIU"
              />
              <title>SwaggerUI</title>
              <link rel="stylesheet" href="https://unpkg.com/swagger-ui-dist@5.20.8/swagger-ui.css" />
            </head>
            <body>
              <div id="swagger-ui"></div>
              <script src="https://unpkg.com/swagger-ui-dist@5.20.8/swagger-ui-bundle.js" crossorigin></script>
              <script src="https://unpkg.com/swagger-ui-dist@5.20.8/swagger-ui-standalone-preset.js" crossorigin></script>
              <script>
                window.onload = () => {
                  window.ui = SwaggerUIBundle({
                    url: '/openapi.json',
                    dom_id: '#swagger-ui',
                  });
                };
              </script>
            </body>
            </html>
        HTML;

    }
}

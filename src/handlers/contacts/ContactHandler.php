<?php

declare(strict_types=1);

namespace wnd\appStub\handlers\contacts;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use wnd\appStub\application\contacts\CreateContactUseCase;
use wnd\appStub\application\contacts\GetContactsListUseCase;
use wnd\appStub\application\contacts\GetContactUseCase;
use wnd\appStub\core\response\JsonResponseFactory;
use wnd\appStub\domain\contacts\ContactCreationRequest;
use wnd\appStub\domain\contacts\ContactNotFoundException;
use OpenApi\Attributes as OA;
use wnd\appStub\application\contacts\DeleteContactUseCase;

#[OA\Info(version: "1.0", title: "Example contacts API")]

class ContactHandler
{
    public function __construct(
        private readonly JsonResponseFactory $responseFactory,
        private readonly ContactTransformer $transformer,
        private readonly GetContactsListUseCase $getContactsListUseCase,
        private readonly GetContactUseCase $getContactUseCase,
        private readonly CreateContactUseCase $createContactUseCase,
        private readonly DeleteContactUseCase $deleteContactUseCase,
    ) {}

    #[OA\Get(
        path: '/contacts',
        operationId: 'contactsList',
        tags: ['Contacts'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Full contact list',
                content: [
                    new OA\JsonContent(
                        type: 'array',
                        items: new OA\Items(ref: '#/components/schemas/ContactItem'),
                    ),
                ],
            ),
        ]
    )]
    #[Route(
        '/contacts',
        'contactsList',
        methods: [Request::METHOD_GET, Request::METHOD_OPTIONS, ],
    )]
    public function get(): Response
    {
        $contacts = $this->getContactsListUseCase->execute();

        return $this->responseFactory->create(
            array_map(
                fn($contact) => $this->transformer->transformToArray($contact),
                $contacts,
            ),
        );
    }

    #[OA\Get(
        path: '/contacts/{contactId}',
        operationId: 'contactDetail',
        tags: ['Contacts'],
        parameters: [
            new OA\Parameter(
                name: 'contactId',
                description: 'Contact ID',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer'),
                style: 'simple',
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Get contact',
                content: [
                    new OA\JsonContent(
                        ref: '#/components/schemas/ContactItem',
                    ),
                ],
            ),
            new OA\Response(
                response: 404,
                description: 'Contact not found',
                content: [
                    new OA\JsonContent(
                        properties: [
                            new OA\Property(
                                property: 'error',
                                type: 'string',
                            ),
                        ],
                        type: 'object',
                    ),
                ],
            ),
        ]
    )]
    #[Route(
        '/contacts/{contactId}',
        'contactDetail',
        requirements: [
            'contactId' => '\d+',
        ],
        methods: [Request::METHOD_GET, Request::METHOD_OPTIONS, ],
    )]
    public function getDetail(string $contactId): Response
    {
        try {
            $contact = $this->getContactUseCase->execute((int) $contactId);
        } catch (ContactNotFoundException) {
            return $this->responseFactory->createError('Contact not found', Response::HTTP_NOT_FOUND);
        }

        return $this->responseFactory->create(
            $this->transformer->transformToArray($contact),
        );
    }

    #[Route(
        '/contacts/{contactId}',
        'deleteContact',
        requirements: ['contactId' => '\d+'],
        methods: [Request::METHOD_DELETE, Request::METHOD_OPTIONS]
    )]
    public function deleteContact(Request $request, string $contactId): Response
    {
        if ($request->getMethod() === Request::METHOD_OPTIONS) {
            return $this->responseFactory->create(
                null,
                Response::HTTP_NO_CONTENT,
                [
                    'Access-Control-Allow-Methods' => 'DELETE, OPTIONS',
                    'Access-Control-Allow-Headers' => 'Content-Type, Authorization',
                ]
            );
        }

        try {
            $this->deleteContactUseCase->execute((int) $contactId);
        } catch (ContactNotFoundException) {
            return $this->responseFactory->createError(
                'Contact not found',
                Response::HTTP_NOT_FOUND
            );
        }

        return $this->responseFactory->create(
            ['message' => 'Contact deleted'],
            Response::HTTP_OK
        );
    }


    #[OA\Post(
        path: '/contacts',
        operationId: 'contactCreate',
        requestBody: new OA\RequestBody(
            content: [
                new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'name',
                            description: 'Contact name',
                            type: 'string',
                        ),
                        new OA\Property(
                            property: 'email',
                            description: 'Contact email',
                            type: 'string',
                        ),
                    ],
                ),
            ],
        ),
        tags: ['Contacts'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Get contact',
                content: [
                    new OA\JsonContent(
                        ref: '#/components/schemas/ContactItem',
                    ),
                ],
            ),
            new OA\Response(
                response: 400,
                description: 'Invalid request data sent.',
                content: [
                    new OA\JsonContent(
                        properties: [
                            new OA\Property(
                                property: 'error',
                                type: 'string',
                            ),
                        ],
                        type: 'object',
                    ),
                ],
            ),
        ],
    )]
    #[Route(
        '/contacts',
        'contactCreate',
        methods: [Request::METHOD_POST, Request::METHOD_OPTIONS,],
    )]
    public function create(Request $request): Response
    {
        try {
            $data = json_decode($request->getContent(), associative: true, flags: JSON_THROW_ON_ERROR);
        } catch (\JsonException) {
            return $this->responseFactory->createError(
                'Invalid json provided',
                Response::HTTP_BAD_REQUEST,
            );
        }

        if (!isset($data['name']) || !is_string($data['name']) ||
            mb_strlen(trim($data['name'])) === 0) {
            return $this->responseFactory->createError(
                'Property "name" is required and must be a non-empty string',
                Response::HTTP_BAD_REQUEST,
            );
        }

        if (!isset($data['email']) || !is_string($data['email']) ||
            !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return $this->responseFactory->createError(
                'Property "email" is required and must be a valid email address',
                Response::HTTP_BAD_REQUEST,
            );
        }

        $contactCreationRequest = new ContactCreationRequest(
            $data['name'],
            $data['email'],
        );

        $contact = $this->createContactUseCase->execute($contactCreationRequest);

        return $this->responseFactory->create(
            $this->transformer->transformToArray($contact),
            Response::HTTP_CREATED,
        );
    }

    #[OA\Delete(
        path: '/contacts',
        operationId: 'contactDelete',
        tags: ['Contacts'],
        parameters: [
            new OA\Parameter(
                name: 'contactId',
                description: 'Contact ID',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer'),
                style: 'simple',
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Contact deleted',
                content: [
                    new OA\JsonContent(
                        properties: [
                            new OA\Property(
                                property: 'message',
                                type: 'string',
                            ),
                        ],
                        type: 'object',
                    ),
                ],
            ),
            new OA\Response(
                response: 404,
                description: 'Contact not found',
                content: [
                    new OA\JsonContent(
                        properties: [
                            new OA\Property(
                                property: 'error',
                                type: 'string',
                            ),
                        ],
                        type: 'object',
                    ),
                ],
            ),
        ],
    )]
    #[Route(
        '/contacts/{contactId}',
        'contactDelete',
        requirements: [
            'contactId' => '\d+',
        ],
        methods: [Request::METHOD_DELETE, Request::METHOD_OPTIONS, ],
    )]
    public function delete(string $contactId): Response
    {
        throw new \RuntimeException("Not implemented ($contactId)");
    }
}

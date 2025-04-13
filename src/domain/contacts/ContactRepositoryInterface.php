<?php

declare(strict_types=1);

namespace wnd\appStub\domain\contacts;

interface ContactRepositoryInterface
{
    public function create(ContactCreationRequest $contactCreationRequest): Contact;

    /**
     * @return Contact[]
     */
    public function getAll(): array;

    /**
     * @throws ContactNotFoundException
     */
    public function getById(int $id): Contact;

    /**
     * @throws ContactNotFoundException
     */
    public function deleteById(int $id): void;
}

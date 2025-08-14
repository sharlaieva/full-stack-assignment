<?php

declare(strict_types=1);

namespace wnd\appStub\application\contacts;

use wnd\appStub\domain\contacts\Contact;
use wnd\appStub\domain\contacts\ContactNotFoundException;
use wnd\appStub\domain\contacts\ContactRepositoryInterface;

class DeleteContactUseCase
{
    public function __construct(
        private readonly ContactRepositoryInterface $contactRepository,
    ) {}

    /**
     * @throws ContactNotFoundException
     */
    public function execute(int $contactId): void
    {
        $this->contactRepository->deleteById($contactId);
    }
}

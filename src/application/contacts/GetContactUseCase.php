<?php

declare(strict_types=1);

namespace wnd\appStub\application\contacts;

use wnd\appStub\domain\contacts\Contact;
use wnd\appStub\domain\contacts\ContactNotFoundException;
use wnd\appStub\domain\contacts\ContactRepositoryInterface;

class GetContactUseCase
{
    public function __construct(
        private readonly ContactRepositoryInterface $contactRepository,
    ) {}

    /**
     * @throws ContactNotFoundException
     */
    public function execute(int $contactId): Contact
    {
        return $this->contactRepository->getById($contactId);
    }
}

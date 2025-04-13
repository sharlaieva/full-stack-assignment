<?php

declare(strict_types=1);

namespace wnd\appStub\application\contacts;

use wnd\appStub\domain\contacts\Contact;
use wnd\appStub\domain\contacts\ContactCreationRequest;
use wnd\appStub\domain\contacts\ContactRepositoryInterface;

class CreateContactUseCase
{
    public function __construct(
        private readonly ContactRepositoryInterface $contactRepository,
    ) {}

    public function execute(ContactCreationRequest $contactCreationRequest): Contact
    {
        return $this->contactRepository->create($contactCreationRequest);
    }
}

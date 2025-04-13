<?php

declare(strict_types=1);

namespace wnd\appStub\application\contacts;

use wnd\appStub\domain\contacts\Contact;
use wnd\appStub\domain\contacts\ContactRepositoryInterface;

class GetContactsListUseCase
{
    public function __construct(
        private readonly ContactRepositoryInterface $contactRepository,
    ) {}

    /**
     * @return Contact[]
     */
    public function execute(): array
    {
        return $this->contactRepository->getAll();
    }
}

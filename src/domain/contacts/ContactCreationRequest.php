<?php

declare(strict_types=1);

namespace wnd\appStub\domain\contacts;

class ContactCreationRequest
{
    public function __construct(
        public string $name,
        public string $email,
    ) {}
}

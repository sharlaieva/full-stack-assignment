<?php

declare(strict_types=1);

namespace wnd\appStub\domain\contacts;

class Contact
{
    public function __construct(
        public readonly int $id,
        public string $name,
        public string $email,
    ) {}
}

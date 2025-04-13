<?php

declare(strict_types=1);

namespace wnd\appStub\handlers\contacts;

use wnd\appStub\domain\contacts\Contact;
use OpenApi\Attributes as OA;


#[OA\Schema(
    schema: "ContactItem",
    description: "Contact Item",
    properties: [
        new OA\Property(
            property: "id",
            description: "Contact Item Id",
            type: "integer",
        ),
        new OA\Property(
            property: "name",
            description: "Contact Name",
            type: "string",
        ),
        new OA\Property(
            property: "email",
            description: "Contact Email",
            type: "email",
        ),

    ],
)]
class ContactTransformer
{
    /**
     * @return array<string, int|string>
     */
    public function transformToArray(Contact $contact): array
    {
        return [
            'id' => $contact->id,
            'name' => $contact->name,
            'email' => $contact->email,
        ];
    }
}

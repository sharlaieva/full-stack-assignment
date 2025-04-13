<?php

declare(strict_types=1);

namespace wnd\appStub\infrastructure\contacts;

use wnd\appStub\domain\contacts\Contact;
use wnd\appStub\domain\contacts\ContactCreationRequest;
use wnd\appStub\domain\contacts\ContactNotFoundException;
use wnd\appStub\domain\contacts\ContactRepositoryInterface;

use function DI\value;

class ContactRepositoryUsingStaticJSON implements ContactRepositoryInterface
{

    public function __construct(
        private readonly string $jsonFilePath,
    ) {}

    public function create(ContactCreationRequest $contactCreationRequest): Contact
    {
        $data = $this->loadData();
        $contact = new Contact(
            id: ++$data['maxIndex'],
            name: $contactCreationRequest->name,
            email: $contactCreationRequest->email,
        );
        $data['data'][] = $contact;
        $this->saveData($data);
        return $contact;
    }

    public function getById(int $id): Contact
    {
        $all = $this->getAll();
        foreach ($all as $contact) {
            if ($contact->id === $id) {
                return $contact;
            }
        }

        throw new ContactNotFoundException();
    }

    public function getAll(): array
    {
        return $this->loadData()['data'];
    }

    public function deleteById(int $id): void
    {
        $data = $this->loadData();
        $cntBefore = count($data['data']);
        $data['data'] = array_filter(
            $data['data'],
            static fn(Contact $contact): bool => $contact->id !== $id,
        );
        if (count($data['data']) === $cntBefore) {
            throw new ContactNotFoundException();
        }
        $this->saveData($data);
    }

    /**
     * @return array{
     *     maxIndex: int,
     *     data: array<int, Contact>,
     * }
     */
    private function loadData(): array
    {
        $data = json_decode(file_get_contents($this->jsonFilePath), true);
        if ($data === null) {
            throw new \RuntimeException('Failed to decode JSON data');
        }
        $contacts = [];
        foreach ($data['data'] as $contactData) {
            $contacts[] = new Contact(
                id: (int)$contactData['id'],
                name: $contactData['name'],
                email: $contactData['email'],
            );
        }
        return [
            'maxIndex' => $data["maxIndex"],
            'data' => $contacts,
        ];
    }

    /**
     * @param array{
     *      maxIndex: int,
     *      data: array<int, Contact>,
     *  } $data
     */
    private function saveData(array $data): void
    {
        $plain = [
            'maxIndex' => $data['maxIndex'],
            'data' => array_map(
                static fn(Contact $contact): array
                    => [
                    'id' => $contact->id,
                    'name' => $contact->name,
                    'email' => $contact->email,
                ],
                $data['data'],
            ),
        ];
        file_put_contents($this->jsonFilePath, json_encode($plain, JSON_PRETTY_PRINT));
    }
}

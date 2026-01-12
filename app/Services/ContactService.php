<?php

namespace App\Services;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ContactService
{
    private const CONTACT_FIELDS = ['name', 'email', 'website'];

    public function storeContact(Model $parent, array $contactData): ?Contact
    {
        return DB::transaction(function () use ($contactData, $parent) {
            $contact = $parent->contact()->create($contactData);
            return $contact;
        });
    }

    public function updateContact(Contact $contact, array $contactData): ?Contact
    {
        return DB::transaction(function () use ($contact, $contactData) {
            $contact->update($contactData);
            return $contact->fresh();
        });
    }

    public function upsertContact(Model $parent, array $contactData): ?Contact
    {
        $issetContact = $contactData['id'];

        if (!$this->validateContactData($contactData)) {
            // if ($issetContact) {
            //     $parent->contact()->delete();
            // }
            return null;
        }

        if ($issetContact) {
            $contact = $parent->contact()->where('id', $contactData['id'])->firstOrFail();
            return $this->updateContact($contact, $contactData);
        }
        
        return $this->storeContact($parent, $contactData);
    }

    private function validateContactData(array $contactData): bool
    {
        return collect(self::CONTACT_FIELDS)->some(fn($field) => !empty($contactData[$field]));
    }
}

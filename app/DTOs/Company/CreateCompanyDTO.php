<?php

namespace App\DTOs\Company;

use Illuminate\Http\Request;

/**
 * CreateCompanyDTO
 * Data Transfer Object for creating a new company registration
 *
 * This DTO encapsulates all data required to create a new company record,
 * with complete type safety and readonly properties following clean architecture.
 */
class CreateCompanyDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly ?string $description = null,
        public readonly ?string $website = null,
        public readonly ?string $phone = null,
        public readonly ?string $address = null,
        public readonly ?string $city = null,
        public readonly ?string $state = null,
        public readonly ?string $country = null
    ) {
    }

    /**
     * Create DTO from validated request data
     *
     * @param Request $request The HTTP request containing validated company data
     * @return self A new instance of CreateCompanyDTO
     */
    public static function fromRequest(Request $request): self
    {
        return new self(
            name: $request->validated('name'),
            email: $request->validated('email'),
            description: $request->validated('description'),
            website: $request->validated('website'),
            phone: $request->validated('phone'),
            address: $request->validated('address'),
            city: $request->validated('city'),
            state: $request->validated('state'),
            country: $request->validated('country')
        );
    }

    /**
     * Convert DTO to array for database operations
     *
     * @return array Data ready for database insertion
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'description' => $this->description,
            'website' => $this->website,
            'phone' => $this->phone,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'country' => $this->country,
        ];
    }
}

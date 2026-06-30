<?php

namespace App\DTOs\Company;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

/**
 * UpdateCompanyDTO
 * Data Transfer Object for updating company information
 *
 * All properties are optional to allow partial updates following REST standards.
 * Only properties that are explicitly set will be updated in the database.
 */
class UpdateCompanyDTO
{
    public function __construct(
        public readonly ?string $name = null,
        public readonly ?string $email = null,
        public readonly ?string $description = null,
        public readonly ?string $website = null,
        public readonly ?string $phone = null,
        public readonly ?string $address = null,
        public readonly ?string $city = null,
        public readonly ?string $state = null,
        public readonly ?string $country = null,
        public readonly ?UploadedFile $logo = null,
        public readonly ?UploadedFile $certificate = null
    ) {
    }

    /**
     * Create DTO from validated request data
     *
     * @param Request $request The HTTP request containing validated company data
     * @return self A new instance of UpdateCompanyDTO
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
            country: $request->validated('country'),
            logo: $request->file('logo'),
            certificate: $request->file('certificate')
        );
    }

    /**
     * Convert DTO to array for database operations
     *
     * Only includes non-null values to enable partial updates.
     *
     * @return array Data ready for database update
     */
    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'email' => $this->email,
            'description' => $this->description,
            'website' => $this->website,
            'phone' => $this->phone,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'country' => $this->country,
        ], fn($value) => $value !== null);
    }
}

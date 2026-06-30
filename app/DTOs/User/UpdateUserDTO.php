<?php

namespace App\DTOs\User;

use Illuminate\Http\Request;

class UpdateUserDTO
{
    public function __construct(
        public readonly string $id,
        public readonly ?string $name = null,
        public readonly ?string $email = null,
        public readonly ?string $password = null,
        public readonly ?string $role = null,
        public readonly ?string $status = null,
    ) {
    }

    /**
     * Create DTO from validated request data
     */
    public static function fromRequest(Request $request): self
    {
        return new self(
            id: $request->route('id'),
            name: $request->validated('name'),
            email: $request->validated('email'),
            password: $request->validated('password'),
            role: $request->validated('role'),
            status: $request->validated('status'),
        );
    }

    /**
     * Convert DTO to array
     */
    public function toArray(): array
    {
        $data = [];
        if ($this->name !== null) {
            $data['name'] = $this->name;
        }
        if ($this->email !== null) {
            $data['email'] = $this->email;
        }
        if ($this->password !== null) {
            $data['password'] = $this->password;
        }
        if ($this->role !== null) {
            $data['role'] = $this->role;
        }
        if ($this->status !== null) {
            $data['status'] = $this->status;
        }
        return $data;
    }
}

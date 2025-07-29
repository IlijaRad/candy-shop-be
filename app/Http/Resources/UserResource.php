<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class UserResource extends JsonResource
{
    public const ID = 'id';
    public const EMAIL = 'email';
    public const EMAIL_VERIFIED_AT = 'email_verified_at';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            self::ID => $this->id,
            self::EMAIL => $this->email,
            self::EMAIL_VERIFIED_AT => $this->email_verified_at?->format('Y-m-d'),
            self::CREATED_AT => $this->created_at->format('Y-m-d'),
            self::UPDATED_AT => $this->updated_at->format('Y-m-d'),
        ];
    }
}

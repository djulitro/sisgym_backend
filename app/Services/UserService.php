<?php

namespace App\Services;

use App\Models\Subcription;
use App\Models\User;

class UserService
{
    protected $organizationId;

    public function __construct(int $organizationId)
    {
        $this->organizationId = $organizationId;
    }

    public function getAllStudent(): array
    {
        $students = User::where('organization_id', $this->organizationId)
        ->where('user_type_id', 4)
        ->get();

        return $students->toArray();
    }

    public function getStudent(int $userId): array
    {
        $student = User::where('organization_id', $this->organizationId)
        ->where('user_type_id', 4)
        ->where('id', $userId)
        ->first();

        return $student->toArray();
    }
}
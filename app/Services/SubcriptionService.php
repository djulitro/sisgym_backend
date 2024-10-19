<?php

namespace App\Services;

use App\Models\Subcription;

class SubcriptionService
{
    protected $organizationId;

    public function __construct(int $organizationId)
    {
        $this->organizationId = $organizationId;    
    }

    public function getAll(): array
    {
        $subcriptions = Subcription::where('organization_id', $this->organizationId)->get();

        return $subcriptions->toArray();
    }

    public function getById(int $id): array
    {
        $subcription = Subcription::where('organization_id', $this->organizationId)
        ->where('id', $id)
        ->first();

        return $subcription->toArray();
    }

    public function create(array $data): array
    {
        $data['organization_id'] = $this->organizationId;

        $subcription = Subcription::create($data);

        return $subcription->toArray();
    }

    public function update(int $id, array $data): array
    {
        $subcription = Subcription::find($id);
        $subcription->update($data);

        return $subcription->toArray();
    }

    public function delete(int $id): bool
    {
        $subcription = Subcription::find($id);
        $subcription->delete();

        return true;
    }
}
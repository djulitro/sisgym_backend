<?php

namespace App\Http\Controllers;

use App\Http\Requests\Subcriptions\SubcriptionCreateRequest;
use App\Models\Subcription;
use App\Services\SubcriptionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubcriptionController extends Controller
{
    public function getAll()
    {
        $subcriptionService = new SubcriptionService(auth()->user()->organization_id);

        return response()->json([
            'success' => true,
            'message' => 'Subcripciones encontradas correctamente',
            'data' => $subcriptionService->getAll()
        ]);
    }

    public function getById(int $id)
    {
        $subcriptionService = new SubcriptionService(auth()->user()->organization_id);

        return response()->json([
            'success' => true,
            'message' => 'Subcripción encontrada correctamente',
            'data' => $subcriptionService->getById($id)
        ]);
    }

    public function create(SubcriptionCreateRequest $request)
    {
        $subcriptionService = new SubcriptionService($request->user()->organization_id);

        $subcription = $subcriptionService->create(
            $request->safe()->all(), 
            $request->user()->organization_id
        );

        return response()->json([
            'success' => true,
            'message' => 'Subcripción creada correctamente',
            'data' => $subcription
        ]);
    }

    public function update(SubcriptionCreateRequest $request, int $id)
    {
        $subcriptionService = new SubcriptionService($request->user()->organization_id);

        $subcription = $subcriptionService->update(
            $id,
            $request->safe()->all()
        );

        return response()->json([
            'success' => true,
            'message' => 'Subcripción actualizada correctamente',
            'data' => $subcription
        ]);
    }

    public function delete(int $id)
    {
        $subcriptionService = new SubcriptionService(Auth::user()->organization_id);

        $subcriptionService->delete($id);

        return response()->json([
            'success' => true,
            'message' => 'Subcripción eliminada correctamente'
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\Payments\PaymentCreateRequest;
use App\Http\Requests\Payments\PaymentUpdateRequest;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function create(PaymentCreateRequest $request)
    {
        $paymentService = new PaymentService(Auth::user()->organization_id);

        $payment = $paymentService->create($request->safe()->all());

        return response()->json([
            'message' => 'Pago registrado correctamente',
            'data' => $payment,
        ]);
    }

    public function update(PaymentUpdateRequest $request, int $id)
    {
        $paymentService = new PaymentService(Auth::user()->organization_id);

        $payment = $paymentService->update($id, $request->safe()->all());

        return response()->json([
            'message' => 'Pago actualizado correctamente',
            'data' => $payment,
        ]);
    }
}

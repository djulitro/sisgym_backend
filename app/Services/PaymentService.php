<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\Subcription;
use Carbon\Carbon;

class PaymentService
{
    protected $organizationId;

    public function __construct(int $organizationId)
    {
        $this->organizationId = $organizationId;    
    }

    public function getByDates(string $startDate, string $endDate)
    {
        return Payment::where('organization_id', $this->organizationId)
        ->whereBetween('start_date', [$startDate, $endDate])
        ->get()
        ->toArray();
    }

    public function getById(int $id)
    {
        return Payment::where('organization_id', $this->organizationId)
        ->where('id', $id)
        ->first()
        ->toArray();
    }

    public function getByStudent(int $studentId)
    {
        return Payment::where('organization_id', $this->organizationId)
        ->where('user_id', $studentId)
        ->get()
        ->toArray();
    }

    public function create(array $data)
    {
        $subcriptionService = new SubcriptionService($this->organizationId);
        $userService = new UserService($this->organizationId);

        $subcription = $subcriptionService->getById($data['subcription_id']);
        $student = $userService->getStudent($data['user_id']);

        if (!$subcription) {
            throw new \Exception('La suscripción no existe');
        }

        if (!$student) {
            throw new \Exception('El estudiante no existe');
        }

        $payment = new Payment();

        $payment->user_id = $data['user_id'];
        $payment->subcription_id = $data['subcription_id'];
        $payment->organization_id = $this->organizationId;
        $payment->start_date = $data['start_date'];
        $payment->end_date = $this->calculateEndDate($data['start_date'], $subcription['days_duration']);

        $payment->save();

        return $payment->toArray();
    }

    public function update(int $id, array $data)
    {
        $subcriptionService = new SubcriptionService($this->organizationId);
        $userService = new UserService($this->organizationId);

        $payment = Payment::find($id);

        if (!$payment) {
            throw new \Exception('El pago no existe');
        }

        $subcription = $subcriptionService->getById($data['subcription_id']);
        $student = $userService->getStudent($data['user_id']);

        if (!$subcription) {
            throw new \Exception('La suscripción no existe');
        }

        if (!$student) {
            throw new \Exception('El estudiante no existe');
        }

        if ($data['start_date'] != $payment->start_date) {
            $data['end_date'] = $this->calculateEndDate($data['start_date'], $subcription['days_duration']);
        }

        $payment->update($data);

        return $payment->toArray();
    }

    public function delete(int $id)
    {
        $payment = Payment::find($id);

        if (!$payment) {
            throw new \Exception('El pago no existe');
        }

        $payment->delete();
    }

    private function calculateEndDate(string $startDate, int $days)
    {
        $startDate = Carbon::parse($startDate);

        if ($days >= 28 && $days <= 31) {
            $startDate->addMonths(1);
        }else if ($days >= 87 && $days <= 95) {
            $startDate->addMonths(3);
        }else if ($days >= 178 && $days <= 186) {
            $startDate->addMonths(6);
        }else if ($days >= 358 && $days <= 366) {
            $startDate->addYear();
        }

        return $startDate->toDateString();
    }
}
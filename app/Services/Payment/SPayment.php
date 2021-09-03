<?php

namespace App\Services\Payment;

use App\Models\Payment;
use App\Models\PaymentStatus;
use App\Models\PaymentType;
use App\Services\Payment\IPayment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SPayment implements IPayment
{
    private $payment;
    private $paymentStatus;
    private $paymentType;

    public function __construct(Payment $payment, PaymentStatus $paymentStatus, PaymentType $paymentType)
    {
        $this->payment = $payment;
        $this->paymentStatus = $paymentStatus;
        $this->paymentType = $paymentType;
    }

    public function getPaymentStatus()
    {
        return $this->paymentStatus->get();
    }

    public function create($input)
    {
        $data = array(
            'status'  => false,
            'message' => '',
            'id'      => null,
        );

        try {
            DB::beginTransaction();
            $payment = Payment::create($input);
            DB::commit();
            $data['status'] = true;
            $data['message'] = 'OK';
            $data['id'] = $payment->id;
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            $data['message'] = $e->getMessage();
        }

        return $data;
    }

    public function getPaymentMethod()
    {
        return $this->paymentType->where('is_active', 1)->where('is_default', 1)->first();
    }

    public function findByOrderId($id)
    {
        return $this->payment
                    ->with(['payment_type', 'payment_status'])
                    ->where('order_id', $id)
                    ->first();
    }
}

<?php

namespace App\Services\Payment;

use App\Models\PaymentStatus;
use App\Services\Payment\IPayment;

class SPayment implements IPayment
{
    private $paymentStatus;

    public function __construct(PaymentStatus $paymentStatus)
    {
        $this->paymentStatus = $paymentStatus;
    }

    public function getPaymentStatus()
    {
        return $this->paymentStatus->get();
    }
}

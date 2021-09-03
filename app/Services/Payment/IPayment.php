<?php

namespace App\Services\Payment;

interface IPayment
{
    public function getPaymentStatus();
    public function create($input);
    public function getPaymentMethod();
    public function findByOrderId($id);
}

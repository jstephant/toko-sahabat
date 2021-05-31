<?php

namespace App\Http\Controllers;

use App\Services\Customer\SCustomer;
use App\Services\Orders\SOrder;
use App\Services\Payment\SPayment;
use App\Services\SGlobal;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    private $sGlobal;
    private $sOrder;
    private $sCustomer;
    private $sPayment;

    public function __construct(SGlobal $sGlobal, SOrder $sOrder, SCustomer $sCustomer,
        SPayment $sPayment)
    {
        $this->sGlobal = $sGlobal;
        $this->sOrder = $sOrder;
        $this->sCustomer = $sCustomer;
        $this->sPayment = $sPayment;
    }

    public function index()
    {
        $customer = $this->sCustomer->getActive();
        $payment_status = $this->sPayment->getPaymentStatus();

        $data = array(
            'title'          => 'Order',
            'active_menu'    => 'Order',
            'edit_mode'      => 0,
            'customer'       => $customer,
            'payment_status' => $payment_status,
        );

        return $this->sGlobal->view('order.index', $data);
    }

    public function listOrder(Request $request)
    {
        $purchase = $this->sOrder->listOrder($request->start_date, $request->end_date, $request->status, $request->keyword, $request->start, $request->length, $request->order);
        $purchase['draw'] = $request->draw;
        return $purchase;
    }
}

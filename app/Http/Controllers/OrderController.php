<?php

namespace App\Http\Controllers;

use App\Services\Customer\SCustomer;
use App\Services\Orders\SOrder;
use App\Services\Payment\SPayment;
use App\Services\SGlobal;
use App\Services\User\SUser;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    private $sGlobal;
    private $sOrder;
    private $sUser;
    private $sPayment;

    public function __construct(SGlobal $sGlobal, SOrder $sOrder, SUser $sUser,
        SPayment $sPayment)
    {
        $this->sGlobal = $sGlobal;
        $this->sOrder = $sOrder;
        $this->sUser = $sUser;
        $this->sPayment = $sPayment;
    }

    public function index()
    {
        $users = $this->sUser->getActive();

        $data = array(
            'title'          => 'Order',
            'active_menu'    => 'Order',
            'edit_mode'      => 0,
            'users'          => $users,
        );

        return $this->sGlobal->view('order.index', $data);
    }

    public function listOrder(Request $request)
    {
        $purchase = $this->sOrder->listOrder($request->start_date, $request->end_date, $request->staff, $request->keyword, $request->start, $request->length, $request->order);
        $purchase['draw'] = $request->draw;
        return $purchase;
    }

    public function detail($id)
    {
        $data = array(
            'code'         => 200,
            'order'        => null,
            'payment'      => null
        );

        $order = $this->sOrder->findById($id);
        if($order)
        {
            $order->text_sub_total = number_format($order->sub_total, 0, ',', '.');
            $order->text_discount = number_format($order->disc_price, 0, ',', '.');
            $order->text_total = number_format($order->total, 0, ',', '.');

            $order_detail = $this->sOrder->findDetailById($order->id);
            foreach ($order_detail as $value) {
                $value->text_price = number_format($value->price, 0, '.', ',');
                $value->text_sub_total = number_format($value->sub_total, 0, '.', ',');
                $value->text_discount = number_format($value->disc_price, 0, '.', ',');
                $value->text_total = number_format($value->total, 0, '.', ',');
            }
        }

        $payment = $this->sPayment->findByOrderId($order->id);
        if($payment)
        {
            $payment->text_sub_total = number_format($payment->sub_total, 0, ',', '.');
            $payment->text_discount = number_format($payment->disc_price, 0, ',', '.');
            $payment->text_total = number_format($payment->grand_total, 0, ',', '.');
            $payment->text_pay_total = number_format($payment->pay_total, 0, ',', '.');
            $payment->text_pay_change = number_format($payment->pay_change, 0, ',', '.');
        }

        $data = array(
            'order'        => ($order) ? $order : null,
            'order_detail' => ($order_detail) ? $order_detail : null,
            'payment'      => ($payment) ? $payment : null,
        );

        return response()->json($data, 200);
    }

    public function listDetail(Request $request)
    {
        $order_detail = $this->sOrder->listDetailProduct($request->order_id, $request->start, $request->length, $request->order);
        $order_detail['draw'] = $request->draw;
        return $order_detail;
    }
}

<?php

namespace App\Http\Controllers;

use App\Services\Purchase\SPurchase;
use App\Services\Satuan\SSatuan;
use App\Services\SGlobal;
use App\Services\Supplier\SSupplier;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    private $sGlobal;
    private $sPurchase;
    private $sSupplier;
    private $sSatuan;

    public function __construct(SGlobal $sGlobal, SPurchase $sPurchase, SSupplier $sSupplier, SSatuan $sSatuan)
    {
        $this->sGlobal = $sGlobal;
        $this->sPurchase = $sPurchase;
        $this->sSupplier = $sSupplier;
        $this->sSatuan = $sSatuan;
    }

    public function index()
    {
        $supplier = $this->sSupplier->getActive();

        $data = array(
            'title'       => 'Pembelian',
            'active_menu' => 'Pembelian',
            'edit_mode'   => 0,
            'supplier'    => $supplier
        );

        return $this->sGlobal->view('purchase.index', $data);
    }

    public function listPurchase(Request $request)
    {
        $purchase = $this->sPurchase->listPurchase($request->start_date, $request->end_date, $request->keyword, $request->start, $request->length, $request->order);
        $purchase['draw'] = $request->draw;
        return $purchase;
    }

    public function create()
    {
        $code = $this->sPurchase->generateCode('purchase_number', 8);
        $supplier = $this->sSupplier->getActive();
        $satuan = $this->sSatuan->getActive();
        $data = array(
            'title'        => 'Pembelian',
            'active_menu'  => 'Pembelian',
            'edit_mode'    => 1,
            'code'         => $code,
            'supplier'     => $supplier,
            'satuan'       => $satuan
        );

        return $this->sGlobal->view('purchase.create', $data);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\Purchase\CreatePurchaseRequest;
use App\Http\Requests\Purchase\EditPurchaseRequest;
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
        $code = $this->sGlobal->generateCode('code', 'purchase', 'purchase_number', 8);
        $supplier = $this->sSupplier->getActive();
        $satuan = $this->sSatuan->getActive();
        $data = array(
            'title'        => 'Pembelian',
            'active_menu'  => 'Pembelian',
            'edit_mode'    => 1,
            'mode'         => 'create',
            'code'         => $code,
            'supplier'     => $supplier,
            'satuan'       => $satuan
        );

        return $this->sGlobal->view('purchase.create', $data);
    }

    public function doCreate(CreatePurchaseRequest $request)
    {
        $validated = $request->validated();

        $purchase_number = $request->code;
        $purchase_date = $request->purchase_date;
        $supplier = $request->supplier;
        $notes = $request->notes;
        $sub_total_all = $request->sub_total_all;
        $discount_all = $request->discount_all;
        $total_all = $request->total_all;
        $created_by = $request->session()->get('id');

        $product_ids = $request->products;
        $satuan = $request->satuan;
        $qty = $request->qty;
        $price = $request->price;
        $sub_total = $request->sub_total;
        $disc_pctg = $request->disc_pctg;
        $disc_rp = $request->disc_rp;
        $total = $request->total;

        $input = array(
            'purchase_number' => $purchase_number,
            'purchase_date'   => $purchase_date,
            'supplier_id'     => $supplier,
            'notes'           => $notes,
            'sub_total'       => $sub_total_all,
            'disc_price'      => $discount_all,
            'total'           => $total_all,
            'status_id'       => 2,
            'created_by'      => $created_by,
        );

        $created = $this->sPurchase->create($input);
        if(!$created['status'])
        {
            return redirect()->back()->with('error', $created['message']);
        }

        $purchase_id = $created['id'];
        foreach ($product_ids as $key => $value) {
            $detail = array(
                'purchase_id' => $purchase_id,
                'product_id'  => $value,
                'satuan_id'   => $satuan[$key],
                'qty'         => $qty[$key],
                'price'       => $price[$key],
                'sub_total'   => $sub_total[$key],
                'disc_pctg'   => $disc_pctg[$key],
                'disc_price'  => $disc_rp[$key],
                'total'       => $total[$key],
            );
            $detail_created = $this->sPurchase->createDetail($detail);
        }

        return redirect()->route('purchase.index')->with('success', 'Data berhasil dibuat');
    }

    public function edit($id)
    {
        $purchase = $this->sPurchase->findById($id);
        $supplier = $this->sSupplier->getActive();
        $satuan = $this->sSatuan->getActive();
        $data = array(
            'title'       => 'Pembelian',
            'active_menu' => 'Pembelian',
            'edit_mode'   => 1,
            'mode'        => 'edit',
            'supplier'    => $supplier,
            'purchase'    => $purchase,
            'satuan'      => $satuan,
        );

        return $this->sGlobal->view('purchase.edit', $data);
    }

    public function listDetail($id)
    {
        $detail = $this->sPurchase->findDetailById($id);
        return response()->json($detail, 200);
    }

    public function doUpdate(EditPurchaseRequest $request)
    {
        $validated = $request->validated();

        $purchase_id = $request->purchase_id;
        $purchase_number = $request->code;
        $purchase_date = $request->purchase_date;
        $supplier = $request->supplier;
        $notes = $request->notes;
        $sub_total_all = $request->sub_total_all;
        $discount_all = $request->discount_all;
        $total_all = $request->total_all;
        $updated_by = $request->session()->get('id');

        $product_ids = $request->products;
        $satuan = $request->satuan;
        $qty = $request->qty;
        $price = $request->price;
        $sub_total = $request->sub_total;
        $disc_pctg = $request->disc_pctg;
        $disc_rp = $request->disc_rp;
        $total = $request->total;

        $input = array(
            'purchase_number' => $purchase_number,
            'purchase_date'   => $purchase_date,
            'supplier_id'     => $supplier,
            'notes'           => $notes,
            'sub_total'       => $sub_total_all,
            'disc_price'      => $discount_all,
            'total'           => $total_all,
            'updated_by'      => $updated_by,
            'updated_at'      => date('Y-m-d H:i:s'),
        );

        $updated = $this->sPurchase->update($purchase_id, $input);
        if(!$updated['status'])
        {
            return redirect()->back()->with('error', $updated['message']);
        }

        $deleted = $this->sPurchase->deleteDetailAll($purchase_id);
        if(!$deleted['status'])
        {
            return redirect()->back()->with('error', $deleted['message']);
        }

        foreach ($product_ids as $key => $value) {
            $detail = array(
                'purchase_id' => $purchase_id,
                'product_id'  => $value,
                'satuan_id'   => $satuan[$key],
                'qty'         => $qty[$key],
                'price'       => $price[$key],
                'sub_total'   => $sub_total[$key],
                'disc_pctg'   => $disc_pctg[$key],
                'disc_price'  => $disc_rp[$key],
                'total'       => $total[$key],
            );
            $detail_created = $this->sPurchase->createDetail($detail);
        }

        return redirect()->route('purchase.index')->with('success', 'Data berhasil diupdate');
    }

    public function doDelete($id)
    {
        $deleted = $this->sPurchase->delete($id);
        if(!$deleted['status'])
        {
            return redirect()->back()->with('error', $deleted['message']);
        }
        return redirect()->route('purchase.index')->with('success', 'Data berhasil dihapus');
    }
}

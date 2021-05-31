<?php

namespace App\Http\Controllers;

use App\Http\Requests\Supplier\CreateSupplierRequest;
use App\Http\Requests\Supplier\EditSupplierRequest;
use App\Services\SGlobal;
use App\Services\Supplier\SSupplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    private $sGlobal;
    private $sSupplier;

    public function __construct(SGlobal $sGlobal, SSupplier $sSupplier)
    {
        $this->sGlobal = $sGlobal;
        $this->sSupplier = $sSupplier;
    }

    public function index()
    {
        $data = array(
            'title'       => 'Supplier',
            'active_menu' => 'Supplier',
            'edit_mode'   => 0
        );

        return $this->sGlobal->view('supplier.index', $data);
    }

    public function listSupplier(Request $request)
    {
        $supplier = $this->sSupplier->listSupplier($request->keyword, $request->start, $request->length, $request->order);
        $supplier['draw'] = $request->draw;
        return $supplier;
    }

    public function create()
    {
        $data = array(
            'title'       => 'Create Supplier',
            'active_menu' => 'Create Supplier',
            'edit_mode'   => 1,
        );

        return $this->sGlobal->view('supplier.create', $data);
    }

    public function doCreate(CreateSupplierRequest $request)
    {
        $validated = $request->validated();

        $name = $request->name;
        $phone = $request->phone;
        $email = $request->email;
        $address = $request->address;

        $input = array(
            'name'         => $name,
            'mobile_phone' => $phone,
            'email'        => $email,
            'address'      => $address,
            'created_by'   => $request->session()->get('id'),
        );

        $created = $this->sSupplier->create($input);
        if(!$created['status'])
        {
            return redirect()->back()->with('error', $created['message']);
        }

        return redirect()->route('supplier.index')->with('success', 'Data berhasil dibuat');
    }

    public function edit($id)
    {
        $supplier = $this->sSupplier->findById($id);
        $data = array(
            'title'       => 'Edit Supplier',
            'active_menu' => 'Edit Supplier',
            'edit_mode'   => 1,
            'supplier'    => $supplier
        );

        return $this->sGlobal->view('supplier.edit', $data);
    }

    public function doUpdate(EditSupplierRequest $request)
    {
        $validated = $request->validated();

        $supplier_id = $request->supplier_id;
        $name = $request->name;
        $phone = $request->phone;
        $email = $request->email;
        $address = $request->address;
        $status = $request->status;

        $input = array(
            'name'         => $name,
            'mobile_phone' => $phone,
            'email'        => $email,
            'address'      => $address,
            'is_active'    => $status,
            'updated_by'   => $request->session()->get('id'),
            'updated_at'   => date('Y-m-d H:i:s'),
        );

        $updated = $this->sSupplier->update($supplier_id, $input);
        if(!$updated['status'])
        {
            return redirect()->back()->with('error', $updated['message']);
        }

        return redirect()->route('supplier.index')->with('success', 'Data berhasil diupdate');
    }

    public function listActive(Request $request)
    {
        return $this->sSupplier->getActive($request->q);
    }

    public function doDelete($id)
    {
        $deleted = $this->sSupplier->delete($id);
        if(!$deleted['status'])
        {
            return redirect()->back()->with('error', $deleted['message']);
        }
        return redirect()->route('supplier.index')->with('success', 'Data berhasil dihapus');
    }
}

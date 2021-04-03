<?php

namespace App\Http\Controllers;

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

    public function doCreate(Request $request)
    {
        $name = $request->name;
        $phone = $request->phone;
        $email = $request->email;
        $address = $request->address;

        $input = array(
            'name'         => $name,
            'mobile_phone' => $phone,
            'email'        => $email,
            'address'      => $address,
        );

        $created = $this->sSupplier->create($input);
        if(!$created['status'])
        {
            alert()->error('Error', $created['message']);
            return redirect()->back()->withInput();
        }

        alert()->success('Success', 'Data updated successfully');
        return redirect()->route('supplier.index');
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

    public function doUpdate(Request $request)
    {
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
            'updated_at'   => date('Y-m-d H:i:s'),
        );

        $updated = $this->sSupplier->update($supplier_id, $input);
        if(!$updated['status'])
        {
            alert()->error('Error', $updated['message']);
            return redirect()->back()->withInput();
        }

        alert()->success('Success', 'Data updated successfully');
        return redirect()->route('supplier.index');
    }
}

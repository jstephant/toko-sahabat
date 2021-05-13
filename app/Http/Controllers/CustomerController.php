<?php

namespace App\Http\Controllers;

use App\Http\Requests\Customer\CreateCustomerRequest;
use App\Http\Requests\Customer\EditCustomerRequest;
use App\Services\Customer\SCustomer;
use App\Services\SGlobal;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    private $sGlobal;
    private $sCustomer;

    public function __construct(SGlobal $sGlobal, SCustomer $sCustomer)
    {
        $this->sGlobal = $sGlobal;
        $this->sCustomer = $sCustomer;
    }

    public function index()
    {
        $data = array(
            'title'       => 'Pelanggan',
            'active_menu' => 'Pelanggan',
            'edit_mode'   => 0
        );

        return $this->sGlobal->view('customer.index', $data);
    }

    public function listCustomer(Request $request)
    {
        $customers = $this->sCustomer->listCustomer($request->keyword, $request->start, $request->length, $request->order);
        $customers['draw'] = $request->draw;
        return $customers;
    }

    public function create()
    {
        $data = array(
            'title'       => 'Create Pelanggan',
            'active_menu' => 'Create Pelanggan',
            'edit_mode'   => 1,
        );

        return $this->sGlobal->view('customer.create', $data);
    }

    public function doCreate(CreateCustomerRequest $request)
    {
        $validate = $request->validated();

        $name = $request->name;
        $phone = $request->phone;
        $address = $request->address;

        $input = array(
            'name'         => $name,
            'mobile_phone' => $phone,
            'address'      => $address,
            'created_by'   => $request->session()->get('id'),
        );

        $created = $this->sCustomer->create($input);
        if(!$created['status'])
        {
            alert()->error('Error', );
            return redirect()->back()->with('error', $created['message']);
        }

        return redirect()->route('customer.index')->with('success', 'Data berhasil dibuat');
    }

    public function edit($id)
    {
        $customer = $this->sCustomer->findById($id);
        $data = array(
            'title'       => 'Edit Pelanggan',
            'active_menu' => 'Edit Pelanggan',
            'edit_mode'   => 1,
            'customer'    => $customer
        );

        return $this->sGlobal->view('customer.edit', $data);
    }

    public function doUpdate(EditCustomerRequest $request)
    {
        $validate = $request->validated();

        $customer_id = $request->customer_id;
        $name = $request->name;
        $phone = $request->phone;
        $address = $request->address;
        $status = $request->status;

        $input = array(
            'name'         => $name,
            'mobile_phone' => $phone,
            'address'      => $address,
            'is_active'    => $status,
            'updated_by'   => $request->session()->get('id'),
            'updated_at'   => date('Y-m-d H:i:s'),
        );

        $updated = $this->sCustomer->update($customer_id, $input);
        if(!$updated['status'])
        {
            return redirect()->back()->with('error', $updated['message']);
        }

        return redirect()->route('customer.index')->with('success', 'Data berhasil diupdate');
    }
}

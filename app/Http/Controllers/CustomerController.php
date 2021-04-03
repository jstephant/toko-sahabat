<?php

namespace App\Http\Controllers;

use App\Services\Customer\SCustomer;
use App\Services\SGlobal;
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

    public function doCreate(Request $request)
    {
        $name = $request->name;
        $phone = $request->phone;
        $address = $request->address;

        $input = array(
            'name'         => $name,
            'mobile_phone' => $phone,
            'address'      => $address,
        );

        $created = $this->sCustomer->create($input);
        if(!$created['status'])
        {
            alert()->error('Error', $created['message']);
            return redirect()->back()->withInput();
        }

        alert()->success('Success', 'Data updated successfully');
        return redirect()->route('customer.index');
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

    public function doUpdate(Request $request)
    {
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
            'updated_at'   => date('Y-m-d H:i:s'),
        );

        $updated = $this->sCustomer->update($customer_id, $input);
        if(!$updated['status'])
        {
            alert()->error('Error', $updated['message']);
            return redirect()->back()->withInput();
        }

        alert()->success('Success', 'Data updated successfully');
        return redirect()->route('customer.index');
    }
}

<?php

namespace App\Services\Customer;

use App\Models\Customer;
use App\Services\Customer\ICustomer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class SCustomer implements ICustomer
{
    private $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function create($input)
    {
        $data = array(
            'status'  => false,
            'message' => '',
            'id'      => null,
        );

        try {
            DB::beginTransaction();
            $customer = Customer::create($input);
            DB::commit();
            $data['status'] = true;
            $data['message'] = 'OK';
            $data['id'] = $customer->id;
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            $data['message'] = $e->getMessage();
        }

        return $data;
    }

    public function update($id, $input)
    {
        $data = array(
            'status'  => false,
            'message' => ''
        );

        try {
            DB::beginTransaction();
            $customer = Customer::where('id', $id)->update($input);
            DB::commit();
            $data['status'] = true;
            $data['message'] = 'OK';
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            $data['message'] = $e->getMessage();
        }

        return $data;
    }

    public function delete($id)
    {
        $data = array(
            'status'  => false,
            'message' => ''
        );

        try {
            DB::beginTransaction();
            $customer = Customer::where('id', $id)->first();
            $customer->is_active = 0;
            $customer->save();
            DB::commit();
            $data['status'] = true;
            $data['message'] = 'OK';
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            $data['message'] = $e->getMessage();
        }

        return $data;
    }

    public function findById($id)
    {
        return $this->customer->where('id', $id)->first();
    }

    public function getActive()
    {
        return $this->customer->where('is_active', 1)->get();
    }

    public function getActiveByName($name)
    {
        return $this->customer->where('is_active', 1)->where('name', 'like', '%'.$name.'%')->get();
    }

    public function list($keyword, $start, $length, $order)
    {
        $customer = $this->customer;

        if($keyword)
        {
            $customer = $customer->where('name', 'like', '%'.$keyword.'%');
        }

        $count = $customer->count();

        if($length!=-1) {
            $customer = $customer->offset($start)->limit($length);
        }

        $customer = $customer->get();

        $data = [
            'recordsTotal'    => $count,
            'recordsFiltered' => $count,
            'data'	          => $customer->toArray(),
        ];

        return $data;
    }
}

<?php

namespace App\Services\Supplier;

use App\Models\Supplier;
use App\Services\Supplier\ISupplier;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class SSupplier implements ISupplier
{
    private $supplier;

    public function __construct(Supplier $supplier)
    {
        $this->supplier = $supplier;
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
            $supplier = Supplier::create($input);
            DB::commit();
            $data['status'] = true;
            $data['message'] = 'OK';
            $data['id'] = $supplier->id;
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
            $supplier = Supplier::where('id', $id)->update($input);
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
            $supplier = Supplier::where('id', $id)->first();
            $supplier->is_active = 0;
            $supplier->save();
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
        return $this->supplier->where('id', $id)->first();
    }

    public function getActive()
    {
        return $this->supplier->where('is_active', 1)->orderby('name', 'asc')->get();
    }

    public function getActiveByName($name)
    {
        return $this->supplier->wherw('is_active', 1)->where('name', $name)->get();
    }

    public function listSupplier($keyword, $start, $length, $order)
    {
        $suppliers = $this->supplier->with(['created_user', 'updated_user']);

        if($keyword)
        {
            $suppliers = $suppliers->where('name', 'like', '%'.$keyword.'%')
                                   ->orwhere('mobile_phone', 'like', '%'.$keyword.'%')
                                   ->orwhere('email', 'like', '%'.$keyword.'%')
                                   ->orwhere('address', 'like', '%'.$keyword.'%');
        }

        $count = $suppliers->count();

        if($length!=-1) {
            $suppliers = $suppliers->offset($start)->limit($length);
        }

        if(count($order)>0)
        {
            switch ($order[0]['column']) {
                case 0:
                    $suppliers = $suppliers->orderby('name', $order[0]['dir']);
                    break;
                case 1:
                    $suppliers = $suppliers->orderby('mobile_phone', $order[0]['dir']);
                    break;
                case 2:
                    $suppliers = $suppliers->orderby('email', $order[0]['dir']);
                    break;
                case 3:
                    $suppliers = $suppliers->orderby('address', $order[0]['dir']);
                    break;
                case 5:
                    $suppliers = $suppliers->orderby('created_at', $order[0]['dir']);
                    break;
                default:
                    $suppliers = $suppliers->orderby('created_at', $order[0]['dir']);
                    break;
            }
        }

        $suppliers = $suppliers->get();

        $data = [
            'recordsTotal'    => $count,
            'recordsFiltered' => $count,
            'data'	          => $suppliers->toArray(),
        ];

        return $data;
    }
}

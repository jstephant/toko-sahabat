<?php

namespace App\Services\Satuan;

use App\Models\Satuan;
use App\Services\Satuan\ISatuan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class SSatuan implements ISatuan
{
    private $satuan;

    public function __construct(Satuan $satuan)
    {
        $this->satuan = $satuan;
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
            $satuan = Satuan::create($input);
            DB::commit();
            $data['status'] = true;
            $data['message'] = 'OK';
            $data['id'] = $satuan->id;
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
            $satuan = Satuan::where('id', $id)->update($input);
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
            $satuan = Satuan::where('id', $id)->first();
            $satuan->is_active = 0;
            $satuan->save();
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
        return $this->satuan->where('id', $id)->first();
    }

    public function getActive()
    {
        return $this->satuan->where('is_active', 1)->get();
    }

    public function listSatuan($keyword, $start, $length, $order)
    {
        $satuan = $this->satuan;

        if($keyword)
        {
            $satuan = $satuan->where('name', 'like', '%'.$keyword.'%')
                             ->orwhere('code', 'like', '%'.$keyword.'%');
        }

        $count = $satuan->count();

        if($length!=-1) {
            $satuan = $satuan->offset($start)->limit($length);
        }

        $satuan = $satuan->get();

        $data = [
            'recordsTotal'    => $count,
            'recordsFiltered' => $count,
            'data'	          => $satuan->toArray(),
        ];

        return $data;
    }

    public function findData($field, $keyword)
    {
        return $this->satuan->where($field, $keyword)->first();
    }
}

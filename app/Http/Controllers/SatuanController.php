<?php

namespace App\Http\Controllers;

use App\Http\Requests\Satuan\SatuanRequest;
use App\Models\Satuan;
use App\Services\Satuan\SSatuan;
use App\Services\SGlobal;
use Illuminate\Http\Request;

class SatuanController extends Controller
{
    private $sGlobal;
    private $sSatuan;

    public function __construct(SGlobal $sGlobal, SSatuan $sSatuan)
    {
        $this->sGlobal = $sGlobal;
        $this->sSatuan = $sSatuan;
    }

    public function index()
    {
        $data = array(
            'title'       => 'Satuan',
            'active_menu' => 'Satuan',
            'edit_mode'   => 0
        );

        return $this->sGlobal->view('satuan.index', $data);
    }

    public function listSatuan(Request $request)
    {
        $satuan = $this->sSatuan->listSatuan($request->keyword, $request->start, $request->length, $request->order);
        $satuan['draw'] = $request->draw;

        return $satuan;
    }

    public function listActive(Request $request)
    {
        return $this->sSatuan->getActive($request->q);
    }

    public function doSave(SatuanRequest $request)
    {
        $validated = $request->validated();

        $data = array(
            'status'  => true,
            'message' => ''
        );

        $mode = $request->mode;
        $satuan_id = $request->satuan_id;
        $code = $request->code;
        $name = $request->name;
        $status = $request->status;
        $qty = $request->qty;

        if($mode=='create')
        {
            $input = array(
                'code' => $code,
                'name' => $name,
                'qty'  => $qty,
            );

            $created = $this->sSatuan->create($input);
            if(!$created['status'])
            {
                $data['status'] = $created['status'];
                $data['message'] = $created['message'];
                return response()->json($data, 200);
            }
        } elseif($mode=='edit')
        {
            $input = array(
                'code'       => $code,
                'name'       => $name,
                'qty'        => $qty,
                'is_active'  => $status,
                'updated_at' => date('Y-m-d H:i:s')
            );

            $updated = $this->sSatuan->update($satuan_id, $input);
            if(!$updated['status'])
            {
                $data['status'] = $updated['status'];
                $data['message'] = $updated['message'];
                return response()->json($data, 200);
            }
        }

        $request->session()->flash('success', 'Data berhasil diupdate');
        return response()->json($data, 200);
    }

    public function doDelete($id)
    {
        $deleted = $this->sSatuan->delete($id);
        if(!$deleted['status'])
        {
            return redirect()->back()->with('error', $deleted['message']);
        }
        return redirect()->route('satuan.index')->with('success', 'Data berhasil dihapus');
    }
}

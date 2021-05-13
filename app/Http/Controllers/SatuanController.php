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

    public function listActive()
    {
        $satuan = $this->sSatuan->getActive();
        return response()->json($satuan, 200);
    }

    public function doSave(SatuanRequest $request)
    {
        $validated = $request->validated();

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
                return redirect()->back()->with('error', $created['message']);
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
                return redirect()->back()->with('error', $updated['message']);
            }
        }

        return redirect()->route('satuan.index')->with('success', 'Data berhasil diupdate');
    }
}

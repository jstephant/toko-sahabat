<?php

namespace App\Http\Controllers;

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

    public function doSave(Request $request)
    {
        $mode = $request->mode;
        $satuan_id = $request->satuan_id;
        $code = $request->code;
        $name = $request->name;
        $status = $request->status;

        if($mode=='create')
        {
            $input = array(
                'code' => $code,
                'name' => $name
            );

            $created = $this->sSatuan->create($input);
            if(!$created['status'])
            {
                alert()->error('Error', $created['message']);
                return redirect()->back()->withInput();
            }
        } elseif($mode=='edit')
        {
            $input = array(
                'code'       => $code,
                'name'       => $name,
                'is_active'  => $status,
            );

            $updated = $this->sSatuan->update($satuan_id, $input);
            if(!$updated['status'])
            {
                alert()->error('Error', $updated['message']);
                return redirect()->back()->withInput();
            }
        }

        alert()->success('Success', 'Data updated successfully');
        return redirect()->route('satuan.index');
    }

    public function checkData($field, $keyword)
    {
        $satuan = $this->sSatuan->findData($field, $keyword);
        return ($satuan) ? 0 : 1;
    }


}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\CategoryRequest;
use App\Services\Category\SCategory;
use App\Services\SGlobal;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $sGlobal;
    private $sCategory;

    public function __construct(SGlobal $sGlobal, SCategory $sCategory)
    {
        $this->sGlobal = $sGlobal;
        $this->sCategory = $sCategory;
    }

    public function index()
    {
        $data = array(
            'title'       => 'Kategori',
            'active_menu' => 'Kategori',
            'edit_mode'   => 0,
        );

        return $this->sGlobal->view('category.index', $data);
    }

    public function listCategory(Request $request)
    {
        $categories = $this->sCategory->listCategory($request->keyword, $request->start, $request->length, $request->order);
        $categories['draw'] = $request->draw;
        return $categories;
    }

    public function checkData($field, $keyword)
    {
        $category = $this->sCategory->checkData($field, $keyword);
        return ($category) ? 0 : 1;
    }

    public function doSave(CategoryRequest $request)
    {
        $validated = $request->validated();

        $data = array(
            'status'  => true,
            'message' => '',
        );

        $mode = $request->mode;
        $category_id = $request->category_id;
        $name = $request->name;
        $status = $request->status;

        if($mode=='create')
        {
            $input = array(
                'name' => $name
            );

            $created = $this->sCategory->create($input);
            if(!$created['status'])
            {
                $data['status'] = $created['status'];
                $data['message'] = $created['message'];
                return response()->json($data, 200);
            }
        } elseif($mode=='edit')
        {
            $input = array(
                'name'       => $name,
                'is_active'  => $status,
            );

            $updated = $this->sCategory->update($category_id, $input);
            if(!$updated['status'])
            {
                $data['status'] = $updated['status'];
                $data['message'] = $updated['message'];
                return response()->json($data, 200);
            }
        }
        $request->session()->put('success', 'Data berhasil diupdate');
        return response()->json($data, 200);
    }

    public function listActive(Request $request)
    {
        return $this->sCategory->getActive($request->keyword);
    }

    public function doDelete($id)
    {
        $deleted = $this->sCategory->delete($id);
        if(!$deleted['status'])
        {
            return redirect()->back()->with('error', $deleted['message']);
        }
        return redirect()->route('category.index')->with('success', 'Data berhasil dihapus');
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubCategory\SubCategoryRequest;
use App\Services\Category\SCategory;
use App\Services\SGlobal;
use App\Services\SubCategory\SSubCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    private $sGlobal;
    private $sSubCategory;
    private $sCategory;

    public function __construct(SGlobal $sGlobal, SSubCategory $sSubCategory, SCategory $sCategory)
    {
        $this->sGlobal = $sGlobal;
        $this->sSubCategory = $sSubCategory;
        $this->sCategory = $sCategory;
    }

    public function index()
    {
        $categories = $this->sCategory->getActive();

        $data = array(
            'title'       => 'Sub Kategori',
            'active_menu' => 'Sub Kategory',
            'edit_mode'   => 0,
            'categories'  => $categories
        );

        return $this->sGlobal->view('sub-category.index', $data);
    }

    public function listSubCategory(Request $request)
    {
        $sub_category = $this->sSubCategory->listSubCategory($request->category, $request->keyword, $request->start, $request->length, $request->order);
        $sub_category['draw'] = $request->draw;
        return $sub_category;
    }

    public function checkData($field, $keyword)
    {
        $sub_category = $this->sSubCategory->checkData($field, $keyword);
        return ($sub_category) ? 0 : 1;
    }

    public function doSave(SubCategoryRequest $request)
    {
        $validated = $request->validated();

        $data = array(
            'status'  => true,
            'message' => ''
        );

        $mode = $request->sub_mode;
        $sub_category_id = $request->sub_category_id;
        $category_id = $request->category2;
        $name = $request->sub_name;
        $status = $request->sub_status;

        if($mode=='create')
        {
            $input = array(
                'name'        => $name,
                'category_id' => $category_id
            );

            $created = $this->sSubCategory->create($input);
            if(!$created['status'])
            {
                $data['status'] = $created['status'];
                $data['message'] = $created['message'];
                return response()->json($data, 200);
            }
        } elseif($mode=='edit')
        {
            $input = array(
                'name'        => $name,
                'category_id' => $category_id,
                'is_active'   => $status,
            );

            $updated = $this->sSubCategory->update($sub_category_id, $input);
            if(!$updated['status'])
            {
                return $updated;
                $data['status'] = $updated['status'];
                $data['message'] = $updated['message'];
                return response()->json($data, 200);
            }
        }

        $request->session()->put('success', 'Data berhasil diupdate');
        return response()->json($data, 200);
    }

    public function doDelete($id)
    {
        $deleted = $this->sSubCategory->delete($id);
        if(!$deleted['status'])
        {
            return redirect()->back()->with('error', $deleted['message']);
        }
        return redirect()->route('category.index')->with('success', 'Data berhasil dihapus');
    }

    public function listActive(Request $request)
    {
        return $this->sSubCategory->getActive($request->q);
    }
}

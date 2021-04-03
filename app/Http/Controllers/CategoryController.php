<?php

namespace App\Http\Controllers;

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

    public function doSave(Request $request)
    {
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
                alert()->error('Error', $created['message']);
                return redirect()->back()->withInput();
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
                alert()->error('Error', $updated['message']);
                return redirect()->back()->withInput();
            }
        }

        alert()->success('Success', 'Data updated successfully');
        return redirect()->route('category.index');
    }

    public function getActive()
    {
        return $this->sCategory->getActive();
    }
}

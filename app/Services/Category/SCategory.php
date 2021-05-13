<?php

namespace App\Services\Category;

use App\Models\Category;
use App\Models\SubCategory;
use App\Services\Category\ICategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class SCategory implements ICategory
{
    private $category;
    private $subCategory;

    public function __construct(Category $category, SubCategory $subCategory)
    {
        $this->category = $category;
        $this->subCategory = $subCategory;
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
            $category = Category::create($input);
            DB::commit();
            $data['status'] = true;
            $data['message'] = 'OK';
            $data['id'] = $category->id;
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
            $category = Category::where('id', $id)->update($input);
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
            $category = Category::where('id', $id)->first();
            $category->is_active = 0;
            $category->save();
            DB::commit();
            $data['status'] = true;
            $data['message'] = 'OK';
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            $data['message'] = $e->getMessage();
        }

        if(!$data['status'])
        {
            return $data;
        }

        $deleted_sub = $this->deleteSubCategory($category->id);
        return $deleted_sub;
    }

    public function findById($id)
    {
        return $this->category->where('id', $id)->first();
    }

    public function getActive()
    {
        return $this->category->where('is_active', 1)->get();
    }

    public function listCategory($keyword, $start, $length, $order)
    {
        $category = $this->category;

        if($keyword)
        {
            $category = $category->where('name', 'like', '%'.$keyword.'%');
        }

        $count = $category->count();

        if($length!=-1) {
            $category = $category->offset($start)->limit($length);
        }

        if(count($order)>0)
        {
            switch ($order[0]['column']) {
                case 0:
                    $category = $category->orderby('name', $order[0]['dir']);
                    break;
                default:
                    $category = $category->orderby('name', $order[0]['dir']);
                    break;
            }
        }

        $category = $category->get();

        $data = [
            'recordsTotal'    => $count,
            'recordsFiltered' => $count,
            'data'	          => $category->toArray(),
        ];

        return $data;
    }

    public function deleteSubCategory($category_id)
    {
        $data = array(
            'status'  => false,
            'message' => ''
        );

        try {
            DB::beginTransaction();
            $sub_category = SubCategory::where('category_id', $category_id)->update(['is_active', 0]);
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
}

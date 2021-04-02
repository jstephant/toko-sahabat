<?php

namespace App\Services\SubCategory;

use App\Models\SubCategory;
use App\Services\SubCategory\ISubCategory;

class SSubCategory implements ISubCategory
{
    private $subCategory;

    public function __construct(SubCategory $subCategory)
    {
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
            $sub_category = SubCategory::create($input);
            DB::commit();
            $data['status'] = true;
            $data['message'] = 'OK';
            $data['id'] = $sub_category->id;
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
            $sub_category = SubCategory::where('id', $id)->update($input);
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
            $sub_category = SubCategory::where('id', $id)->first();
            $sub_category->is_active = 0;
            $sub_category->save();
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
        return $this->subCategory->where('id', $id)->first();
    }

    public function getActive()
    {
        return $this->subCategory->where('is_active', 1)->get();
    }

    public function list($keyword, $start, $length, $order)
    {
        $sub_category = $this->subCategory->with('category');

        if($keyword)
        {
            $sub_category = $sub_category->where('name', 'like', '%'.$keyword.'%');
        }

        $count = $sub_category->count();

        if($length!=-1) {
            $sub_category = $sub_category->offset($start)->limit($length);
        }

        $sub_category = $sub_category->get();

        $data = [
            'recordsTotal'    => $count,
            'recordsFiltered' => $count,
            'data'	          => $sub_category->toArray(),
        ];

        return $data;
    }

    public function getActiveByCategoryId($id)
    {
        return $this->subCategory->where('category_id', $id)->where('is_active', 1)->get();
    }
}

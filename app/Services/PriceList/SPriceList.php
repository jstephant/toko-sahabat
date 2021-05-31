<?php

namespace App\Services\PriceList;

use App\Models\ProductPriceList;
use App\Services\PriceList\IPriceList;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Log;

class SPriceList implements IPriceList
{
    private $productPriceList;

    public function __construct(ProductPriceList $productPriceList)
    {
        $this->productPriceList = $productPriceList;
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
            $price_list = ProductPriceList::create($input);
            DB::commit();
            $data['status'] = true;
            $data['message'] = 'OK';
            $data['id'] = $price_list->id;
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
            $price_list = ProductPriceList::where('id', $id)->update($input);
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

    public function delete($id){}

    public function findById($id)
    {
        return $this->productPriceList->where('id', $id)->first();
    }

    public function findByDate($date, $product_id)
    {
        return $this->productPriceList
                    ->with(['satuan', 'product'])
                    ->whereDate('active_at', $date)
                    ->where('product_id', $product_id)
                    ->first();
    }

    public function findItemByDate($product_id)
    {
        $distinct_date = $this->productPriceList
                              ->where('product_id', $product_id)
                              ->distinct()
                              ->orderby('active_at', 'desc')
                              ->get(['active_at']);

        $price_list = null;
        $last_date = null;
        if(count($distinct_date)>0) {
            $last_date = $distinct_date[0]->active_at;

            $price_list = $this->productPriceList
                                ->with(['satuan', 'product'])
                                ->where('product_id', $product_id)
                                ->whereDate('active_at', $last_date)
                                ->select('product_id', 'satuan_id', 'price')
                                ->get();
        }

        $data = array(
            'active_at'  => $last_date,
            'price_list' => $price_list,
        );

        return $data;
    }

    public function getProductPriceBySatuan($product_id, $satuan_id)
    {
        return $this->productPriceList
                    ->where('product_id', $product_id)
                    ->where('satuan_id', $satuan_id)
                    ->where('active_at', '<=', date('Y-m-d'))
                    ->orderby('active_at', 'desc')
                    ->first();
    }

    public function deleteByIdDate($id, $date)
    {
        $data = array(
            'status'  => false,
            'message' => ''
        );

        try {
            DB::beginTransaction();
            $price_list = ProductPriceList::where('id', $id)->whereDate('active_at', $date)-delete();
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

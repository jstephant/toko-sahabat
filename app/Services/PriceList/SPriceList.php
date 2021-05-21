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

    public function findByDate($date)
    {
        return $this->productPriceList
                    ->with(['satuan', 'product'])
                    ->whereDate('active_at', $date)
                    ->get();
    }

    public function findItemByDate($date, $product_id)
    {
        return $this->productPriceList
                    ->with(['satuan', 'product'])
                    ->whereDate('active_at', $date)
                    ->where('product_id', $product_id)
                    ->first();
    }
}

<?php

namespace App\Http\Controllers;

use App\Services\Cart\SCart;
use App\Services\Customer\SCustomer;
use App\Services\Inventory\SInventory;
use App\Services\Orders\SOrder;
use App\Services\PriceList\SPriceList;
use App\Services\Product\SProduct;
use App\Services\Satuan\SSatuan;
use App\Services\SGlobal;
use App\Services\SubCategory\SSubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class POSController extends Controller
{
    private $sGlobal;
    private $sCart;
    private $sProduct;
    private $sSatuan;
    private $sCustomer;
    private $sOrder;
    private $sSubCategory;
    private $sInventory;
    private $sPriceList;

    public function __construct(SGlobal $sGlobal, SCart $sCart, SProduct $sProduct, SSatuan $sSatuan,
        SCustomer $sCustomer, SOrder $sOrder, SSubCategory $sSubCategory, SInventory $sInventory,
        SPriceList $sPriceList)
    {
        $this->checkSession();
        $this->sGlobal = $sGlobal;
        $this->sCart = $sCart;
        $this->sProduct = $sProduct;
        $this->sSatuan = $sSatuan;
        $this->sCustomer = $sCustomer;
        $this->sOrder = $sOrder;
        $this->sSubCategory = $sSubCategory;
        $this->sInventory = $sInventory;
        $this->sPriceList = $sPriceList;
    }

    public function index(Request $request)
    {
        $user_id = $request->session()->get('user_id');
        $sub_category = $this->sSubCategory->getActive();
        $cart = $this->sCart->findPendingByDate(date('Y-m-d'), $user_id);
        $data = array(
            'title'         => 'POS',
            'active_menu'   => 'POS',
            'edit_mode'     => 0,
            'show_btn_cart' => 1,
            'sub_category'  => $sub_category,
        );
        $total_item = '';
        if($cart && $cart->cart_detail) $total_item = count($cart->cart_detail);

        $request->session()->put('cart_id', ($cart) ? $cart->id : '' );
        $request->session()->put('total_item', $total_item);

        return $this->sGlobal->view('pos.index', $data);
    }

    public function addItem(Request $request)
    {
        $product_id = $request->product_id;
        $satuan_id = $request->satuan_id;
        $qty = $request->qty;
        $price = $request->price;

        $user_id = $request->session()->get('user_id');

        $cart = $this->sCart->findPendingByDate(date('Y-m-d'), $user_id);
        if(!$cart)
        {
            $order_code = $this->sGlobal->generateCode('code', 'cart', 'order_code',  8);
            $input = array(
                'order_code'     => $order_code,
                'order_date'     => date('Y-m-d'),
                'status_id'      => '1',
                'created_by'     => $user_id,
                'created_at'     => date('Y-m-d H:i:s'),
            );
            $cart = $this->sCart->create($input);
            $cart_id = $cart['id'];
        } else {
            $cart_id = $cart->id;
        }

        $cart_detail = $this->sCart->findDetailByIdProduct($cart_id, $product_id);
        if(!$cart_detail)
        {
            $sub_total = $qty * $price;
            $disc_pctg = 0;
            $disc_price = 0;
            $total = $sub_total - $disc_price;

            $input_detail = array(
                'cart_id'    => $cart_id,
                'product_id' => $product_id,
                'satuan_id'  => $satuan_id,
                'qty'        => $qty,
                'price'      => $price,
                'sub_total'  => $sub_total,
                'disc_pctg'  => $disc_pctg,
                'disc_price' => $disc_price,
                'total'      => $total
            );
            $created_detail = $this->sCart->createDetail($input_detail);
        } else {
            $new_qty = $qty + $cart_detail->qty;
            $sub_total = $new_qty * $price;
            $disc_pctg = 0;
            $disc_price = 0;
            $total = $sub_total - $disc_price;

            $input_detail = array(
                'satuan_id'  => $satuan_id,
                'qty'        => $new_qty,
                'price'      => $price,
                'sub_total'  => $sub_total,
                'disc_pctg'  => $disc_pctg,
                'disc_price' => $disc_price,
                'total'      => $total
            );
            $updated_detail = $this->sCart->updateDetail($cart_id, $product_id, $input_detail);
        }

        $hitung_total = $this->sCart->hitungTotal($cart_id);
        $input_update = array(
            'sub_total' => $hitung_total['sub_total'],
            'disc_price' => $hitung_total['disc_price'],
            'total' => $hitung_total['total'],
        );
        $updated = $this->sCart->update($cart_id, $input_update);

        $cart_item = $this->sCart->findDetailById($cart_id);
        $data = array(
            'cart_id'    => $cart_id,
            'total_item' => $cart_item->count(),
        );

        $request->session()->put('cart_id', $data['cart_id']);
        $request->session()->put('total_item', $data['total_item']);

        return $data;
    }

    public function updateQty(Request $request)
    {
        $cart_id = $request->cart_id;
        $product_id = $request->product_id;
        $satuan_id = $request->satuan_id;
        $qty = $request->qty;
        $price = $request->price;
        $sub_total = $request->sub_total;
        $disc_pctg = $request->disc_pctg;
        $disc_price = $request->disc_price;
        $total = $request->total;

        $input = array(
            'satuan_id'  => $satuan_id,
            'qty'        => $qty,
            'price'      => $price,
            'sub_total'  => $sub_total,
            'disc_pctg'  => $disc_pctg,
            'disc_price' => $disc_price,
            'total'      => $total
        );

        $update_detail = $this->sCart->updateDetail($cart_id, $product_id, $input);

        return response()->json($update_detail, 200);
    }

    public function removeItem(Request $request)
    {
        $cart_id = $request->cart_id;
        $product_id = $request->product_id;

        $remove = $this->sCart->deleteDetail($cart_id, $product_id);

        $hitung_total = $this->sCart->hitungTotal($cart_id);
        $input_update = array(
            'sub_total' => $hitung_total['sub_total'],
            'disc_price' => $hitung_total['disc_price'],
            'total' => $hitung_total['total'],
        );
        $updated = $this->sCart->update($cart_id, $input_update);

        $cart = $this->sCart->findById($cart_id);
        $cart_item = $this->sCart->findDetailById($cart_id);
        $total_item = $cart_item->count();

        $data = array(
            'header'     => $cart,
            'total_item' => $total_item
        );

        $request->session()->put('cart_id', $cart_id);
        $request->session()->put('total_item', $total_item);

        return response()->json($data, 200);
    }

    public function doCreateOrder(Request $request)
    {
        $cart_id = $request->cart_id;
        $customer_id = $request->customer_id;
        $customer_name = $request->customer_name;
        $customer_phone = $request->customer_phone;
        $notes = $request->notes;
        $action = $request->action;
        $user_id = $request->session()->get('user_id');

        if($action=='beli')
        {
            if(!$customer_id)
            {
                $customer = $this->sCustomer->findByPhone($customer_phone);
                if(!$customer)
                {
                    $input_customer = array(
                        'name'         => $customer_name,
                        'mobile_phone' => $customer_phone,
                        'created_by'   => $user_id,
                    );
                    $new_customer = $this->sCustomer->create($input_customer);
                    if(!$new_customer['status'])
                    {
                        return redirect()->back()->with('error', $new_customer['message']);
                    }
                    $customer_id = $new_customer['id'];
                } else $customer_id = $customer->id;
            }

            $input = array(
                'customer_id'    => $customer_id,
                'customer_name'  => $customer_name,
                'customer_phone' => $customer_phone,
                'notes'          => $notes,
                'status_id'      => 2,
                'updated_by'     => $user_id,
                'updated_at'     => date('Y-m-d H:i:s'),
            );

            $update_cart = $this->sCart->update($cart_id, $input);

            $cart = $this->sCart->findById($cart_id);
            if($cart)
            {
                $cart_in_order = $this->sOrder->findByCartId($cart_id);
                if(!$cart_in_order)
                {
                    $input_order = array(
                        'order_code' => $cart->order_code,
                        'order_date' => $cart->order_date,
                        'cart_id'    => $cart_id,
                        'customer_id'=> $cart->customer_id,
                        'sub_total'  => $cart->sub_total,
                        'disc_price' => $cart->disc_price,
                        'total'      => $cart->total,
                        'notes'      => $notes,
                        'status_id'  => 2,
                        'created_by' => $user_id,
                    );
                    $order = $this->sOrder->create($input_order);
                    if(!$order['status'])
                    {
                        return redirect()->back()->with('error', $order['message']);
                    }
                    $order_id = $order['id'];
                } else {
                    $order_id = $cart_in_order->id;
                    $update_order = array(
                        'customer_id'=> $cart->customer_id,
                        'sub_total'  => $cart->sub_total,
                        'disc_price' => $cart->disc_price,
                        'total'      => $cart->total,
                        'notes'      => $notes,
                        'status_id'  => 2,
                        'updated_by' => $user_id,
                    );
                    $order = $this->sOrder->update($order_id, $update_order);
                }

                $delete_detail = $this->sOrder->deleteDetailAll($order_id);

                foreach ($cart->cart_detail as $value) {
                    $input_order_detail = array(
                        'order_id'   => $order_id,
                        'product_id' => $value->product_id,
                        'satuan_id'  => $value->satuan_id,
                        'qty'        => $value->qty,
                        'price'      => $value->price,
                        'sub_total'  => $value->sub_total,
                        'disc_pctg'  => $value->disc_pctg,
                        'disc_price' => $value->disc_price,
                        'total'      => $value->total,
                    );
                    $new_detail = $this->sOrder->createDetail($input_order_detail);
                }
            }

            // $request->session()->put('cart_id', null);
            // $request->session()->put('total_item', 0);
        }
        // lanjut ke payment
        //return redirect()->route('pos.index');
    }

    public function listProduct(Request $request)
    {
        $data = array(
            'status'       => false,
            'message'      => '',
            'total_record' => 0,
            'start'        => 0,
            'next_start'   => 0,
            'content'      => '',
        );

        $sub_category = $request->sub_category;
        $keyword = $request->keyword;
        $start = $request->start;

        $products = $this->sOrder->listProduct($sub_category, $keyword, $start, 20);
        if($products['recordsTotal']>0)
        {
            $content = "";
            foreach ($products['data'] as $value) {
                $value->thumbnail = ($value->image_name) ? url('images/product/thumbnail/'.$value->image_name) : url('images/product/thumbnail/default.png');
                $value->stock = $this->sInventory->getStock($value->id, 1);
                $class_stock = ($value->stock>0) ? 'text-success' : 'text-danger';

                $price = 0;
                $product_price = $this->sPriceList->getProductPriceBySatuan($value->id, 1);
                if($product_price) $price = $product_price->price;

                $satuan = $this->sProduct->getProductSatuanById($value->id);
                $default_satuan_id = 1;
                $product_satuan = '<div class="btn-group btn-group-toggle" data-toggle="buttons">';
                foreach ($satuan as $i => $item_satuan) {
                    if($i==0)
                    {
                        $default_satuan_id = $item_satuan->satuan_id;
                        $product_satuan .= '<label for="product_'.$item_satuan->product_id.'_'.$item_satuan->satuan_id.'" class="btn btn-secondary select-satuan active focus">';
                        $product_satuan .= '<input type="radio" name="satuan_name[]" id="product_'.$item_satuan->product_id.'_'.$item_satuan->satuan_id.'" class="radio-satuan" value="'. $item_satuan->satuan_id .'" checked=true>' . $item_satuan->name;
                    } else {
                        $product_satuan .= '<label for="product_'.$item_satuan->product_id.'_'.$item_satuan->satuan_id.'" class="btn btn-secondary select-satuan">';
                        $product_satuan .= '<input type="radio" name="satuan_name[]" id="product_'.$item_satuan->product_id.'_'.$item_satuan->satuan_id.'" class="radio-satuan" value="'. $item_satuan->satuan_id .'" checked=true>' . $item_satuan->name;
                    }
                    $product_satuan .= '</label>';
                }
                $product_satuan .= '</div>';

                $content .= '<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">';
                $content .= '<div class="card">';
                $content .= '<div class="card-body">';
                $content .= '<input type="hidden" name="product_id[]" class="input-product-id" value="' . $value->id . '">';
                $content .= '<input type="hidden" name="satuan_id[]" class="input-satuan-id" value="'.$default_satuan_id.'">';
                $content .= '<div class="row mt-3 align-items-center">';
                $content .= '<div class="col-auto">';
                $content .= '<a href="#!" class="avatar avatar-xl rounded bg-white">';
                $content .= '<img alt="" src="'.$value->thumbnail.'">';
                $content .= '</a>';
                $content .= '</div>';
                $content .= '<div class="col ml--2">';
                $content .= '<h5 class="mb-0">';
                $content .= $value->name;
                $content .= '</h5>';
                $content .= '<span class="'. $class_stock .'">●</span>';
                $content .= '<small class="ml-1 text-stock">Tersedia: ' . $value->stock . '</small>';
                $content .= '<h5 class="mb-0 text-price">Rp ' . $price . '</h5>';
                $content .= '</div>';

                $content .= '<div class="col-lg-auto col-md-auto col-sm-auto col-xs-12 justify-content-end d-flex">';
                if($value->stock > 0)
                {
                    $content .= '<input type="number" name="qty[]" class="form-control input-qty ml-2" value="1" min="1" max="'. $value->stock . '"style="padding:6px; display: inline-block !important; width: auto !important; height:100% !important;">';
                    $content .= '<input type="hidden" name="price[]" class="input-price" value="' . $price . '">';
                    $content .= '<button type="button" class="btn btn-icon btn-sm btn-facebook add-item ml-2">';
                    $content .= '<span class="btn-inner--icon"><i class="ni ni-basket"></i></span>';
                    $content .= '<span class="btn-inner--text">Add</span>';
                    $content .= '</button>';
                }
                $content .= '</div>';
                $content .= '</div>';
                $content .= '<div class="row mt-3"><div class="col-lg-12">' .$product_satuan. '</div></div>';
                $content .= '</div>';
                $content .= '</div>';
                $content .= '</div>';
            }

            $data['status'] = true;
            $data['message'] = 'OK';
            $data['start'] = $start;
            $data['next_start'] = ($products['recordsTotal'] <= 20) ? 1 : (($start==0) ? 1 : $start+1);
            $data['content'] = $content;
            $data['total_record'] = $products['recordsTotal'];
        } else {
            $data['message'] = 'No data to display';
        }

        return response()->json($data, 200);
    }

    public function productPriceList(Request $request)
    {
        $product_id = $request->product_id;
        $satuan_id = $request->satuan_id;

        $price = 0;
        $product_price = $this->sPriceList->getProductPriceBySatuan($product_id, $satuan_id);
        if($product_price) $price = $product_price->price;

        $stock = $this->sInventory->getStock($product_id, $satuan_id);

        $data = array(
            'price' => $price,
            'stock' => $stock,
        );

        return response()->json($data, 200);
    }

    public function cartIndex(Request $request)
    {
        $user_id = $request->session()->get('user_id');
        $cart = $this->sCart->findPendingByDate(date('Y-m-d'), $user_id);
        $customer = $this->sCustomer->getActive();
        $customer_name = $cart->customer_name;
        $customer_phone = $cart->customer_phone;
        $satuan = $this->sSatuan->getActive();
        $data = array(
            'title'          => 'View Cart',
            'active_menu'    => 'View Cart',
            'edit_mode'      => 1,
            'mode'           => 'edit',
            'show_btn_cart'  => 0,
            'cart'           => $cart,
            'customer'       => $customer,
            'customer_name'  => $customer_name,
            'customer_phone' => $customer_phone,
            'satuan'         => $satuan,

        );

        return $this->sGlobal->view('pos.cart', $data);
    }

    public function detailCart($id)
    {
        $cart = $this->sCart->findById($id);
        $details = $this->sCart->findDetailById($id);

        $content = "";
        if($details)
        {
            foreach ($details as $value) {
                $value->thumbnail = ($value->product->image_name) ? url('images/product/thumbnail/'.$value->product->image_name) : url('images/product/thumbnail/default.png');
                $value->stock = $this->sInventory->getStock($value->product_id, $value->satuan_id);
                $class_stock = ($value->stock>0) ? 'text-success' : 'text-danger';

                $link_thumb = '
                    <a href="#!" class="avatar avatar-xl rounded bg-white">
                        <img alt="" src="'.$value->thumbnail.'" style="width:55px; height:55px">
                    </a>';

                $link_description = '
                    <small class="mb-0 d-block">' . $value->product->name . '</small>
                    <span class="'. $class_stock .'">●</span>
                    <small class="text-stock">Tersedia: ' . $value->stock . '</small>
                    <h5 class="mb-0 text-price">Rp' . $value->price . '</h5>';

                $link_satuan =
                    '<a href="#" class="text-default p-0 edit-satuan" title="Pilih Satuan" data-toggle="modal" data-target="#modal-set-satuan"
                        data-cart_id="'.$id.'"
                        data-product_id="' . $value->product_id . '"
                        data-product_name="' . $value->product->name . '"
                        data-satuan_id="' . $value->satuan_id . '"
                        data-satuan_name="' . $value->satuan->name . '"
                        data-source-satuan="product_satuan"
                    ><small class="satuan-text">'.$value->satuan->name.'</small></a>';

                $link_remove = '
                    <button class="btn btn-icon btn-link text-muted p-0 mr-3 remove-item" type="button" data-toggle="tooltip" title="Remove Item">
                        <span class="btn-inner--icon"><i class="fas fa-trash"></i></span>
                    </button>';

                $disabled_min = ($value->qty<=1) ? 'disabled' : '';
                $class_min = ($value->qty<=1) ? 'text-muted' : 'text-success';
                $disabled_plus = ($value->qty>=$value->stock) ? 'disabled' : '';
                $class_plus = ($value->qty>=$value->stock) ? 'text-muted' : 'text-success';

                $link_qty = $link_remove . '
                    <button class="btn btn-icon btn-link min-item p-0 mr-0 ' .$class_min. '" type="button" data-toggle="tooltip" ' . $disabled_min. '>
                        <span class="btn-inner--icon"><i class="fas fa-minus-circle"></i></span>
                    </button>
                    <input type="number" name="qty[]" class="form-control text-center input-qty" value="'.$value->qty.'" min="1" max="'. $value->stock . '"style="padding:6px; display: inline-block !important; width: auto !important; height:100% !important;">
                    <button class="btn btn-icon btn-link plus-item p-0 '.$class_plus.'" type="button" data-toggle="tooltip" '. $disabled_plus .'>
                        <span class="btn-inner--icon"><i class="fas fa-plus-circle"></i></span>
                    </button>';

                $content_disc_pctg = "";
                $content_disc_price = "";
                if($value->disc_pctg>0)
                {
                    $content_disc_pctg .= '<span class="badge badge-sm badge-danger mr-2">' . $value->disc_pctg . '%</span>';
                }

                if($value->disc_price>0)
                {
                    $content_disc_price .= '<small><del>Rp'. $value->disc_price .'</del></small>';
                }
                $content_discount = $content_disc_pctg.$content_disc_price;
                if(!$content_discount)
                {
                    $content_discount = '<small><del>Discount</del></small>';
                }

                $link_discount =
                    '<a href="#" class="text-default pl-0 edit-discount" title="Set Discount" data-toggle="modal" data-target="#modal-set-discount"
                        data-cart_id="'.$id.'"
                        data-product_id="'.$value->product_id.'"
                        data-sub_total="'.$value->sub_total.'"
                        data-disc_pctg="'.$value->disc_pctg.'"
                        data-disc_price="'.$value->disc_price.'"
                    ><span class="discount-text">'.$content_discount.'</span></a>';

                $content .= '<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 col-item">';
                $content .= '<div class="card">';
                $content .= '<div class="card-body p-3">';
                $content .= '<input type="hidden" name="product_id[]" class="input-product-id" value="' . $value->product_id . '">';
                $content .= '<input type="hidden" name="satuan_id[]" class="input-satuan-id" value="' . $value->satuan_id . '">';

                $content .= '<div class="row align-items-center">';
                $content .= '<div class="col mr-auto">'.$link_discount.'</div>';
                $content .= '<div class="col text-right"><small class="item-total-text"> Rp'. $value->total . '</small></div>';
                $content .= '</div>';

                $content .= '<div class="row mt-3 align-items-center">';
                $content .= '<div class="col-auto pl-2 pr-0">'. $link_thumb . '</div>';
                $content .= '<div class="col pl-2">' . $link_description . '</div>';
                $content .= '<input type="hidden" name="price[]" class="input-price" value="' . $value->price . '">';
                $content .= '<input type="hidden" name="sub_total[]" class="input-sub_total" value="' . $value->sub_total . '">';
                $content .= '<input type="hidden" name="disc_pctg[]" class="input-disc_pctg" value="' . $value->disc_pctg . '">';
                $content .= '<input type="hidden" name="disc_price[]" class="input-disc_price" value="' . $value->disc_price . '">';
                $content .= '<input type="hidden" name="total[]" class="input-total" value="' . $value->total . '">';
                $content .= '</div>'; // row

                $content .= '<div class="row mt-2 align-items-center d-flex">';
                $content .= '<div class="col">'.$link_satuan.'</div>';
                $content .= '<div class="col-auto text-right p-0 pr-3">'. $link_qty . '</div>';
                $content .= '</div>';

                $content .= '</div>';
                $content .= '</div>';
                $content .= '</div>';
            }
        }
        $data = array(
            'header'  => $cart,
            'detail'  => $details,
            'content' => $content
        );
        return response()->json($data, 200);
    }

    public function setSatuan(Request $request)
    {
        $cart_id = $request->cart_id;
        $product_id = $request->product_id;
        $satuan_id = $request->satuan_id;

        $cart = $this->sCart->findById($cart_id);
        $detail = $this->sCart->findDetailByIdProduct($cart_id, $product_id);
        if($detail->satuan_id!=$satuan_id)
        {
            $product_price = $this->sPriceList->getProductPriceBySatuan($product_id, $satuan_id);
            $price_satuan = $product_price->price;
            $sub_total = ($detail->qty * $price_satuan);
            $total = $sub_total - $detail->disc_price;

            $input = array(
                'satuan_id' => $satuan_id,
                'price'     => $price_satuan,
                'sub_total' => $sub_total,
                'total'     => $total,
            );

            $updated_detail = $this->sCart->updateDetail($cart_id, $product_id, $input);

            $hitung_total = $this->sCart->hitungTotal($cart_id);
            $input_update = array(
                'sub_total' => $hitung_total['sub_total'],
                'disc_price' => $hitung_total['disc_price'],
                'total' => $hitung_total['total'],
            );
            $updated = $this->sCart->update($cart_id, $input_update);

            $cart = $this->sCart->findById($cart_id);
            $detail = $this->sCart->findDetailByIdProduct($cart_id, $product_id);
        }

        $detail->stock = $this->sInventory->getStock($product_id, $satuan_id);

        $data = array(
            'header' => $cart,
            'detail' => $detail,
        );
        return response()->json($data, 200);
    }

    public function setDiscount(Request $request)
    {
        $cart_id = $request->cart_id;
        $product_id = $request->product_id;
        $disc_pctg = $request->disc_pctg;
        $disc_price = $request->disc_price;

        $cart = $this->sCart->findById($cart_id);
        $detail = $this->sCart->findDetailByIdProduct($cart_id, $product_id);

        if($disc_pctg!=$detail->disc_pctg || $disc_price!=$detail->disc_price)
        {
            $new_total = $detail->sub_total - $disc_price;
            $input = array(
                'disc_pctg'  => $disc_pctg,
                'disc_price' => $disc_price,
                'total'      => $new_total,
            );
            $updated_detail = $this->sCart->updateDetail($cart_id, $product_id, $input);
            $hitung_total = $this->sCart->hitungTotal($cart_id);
            $input_update = array(
                'sub_total' => $hitung_total['sub_total'],
                'disc_price' => $hitung_total['disc_price'],
                'total' => $hitung_total['total'],
            );
            $updated = $this->sCart->update($cart_id, $input_update);
        }

        $cart = $this->sCart->findById($cart_id);
        $detail = $this->sCart->findDetailByIdProduct($cart_id, $product_id);

        $data = array(
            'header' => $cart,
            'detail' => $detail,
        );
        return response()->json($data, 200);
    }

    public function setQty(Request $request)
    {
        $cart_id = $request->cart_id;
        $product_id = $request->product_id;
        $qty = $request->qty;

        $cart = $this->sCart->findById($cart_id);
        $detail = $this->sCart->findDetailByIdProduct($cart_id, $product_id);

        if($qty!=$detail->qty)
        {
            $sub_total = $qty * $detail->price;
            if($detail->disc_pctg>0)
                $disc_price =  ($detail->disc_pctg/100) * $sub_total;
            else $disc_price = $detail->disc_price;
            $total = $sub_total - $disc_price;
            $input = array(
                'qty'        => $qty,
                'sub_total'  => $sub_total,
                'disc_price' => $disc_price,
                'total'      => $total,
            );
            $updated_detail = $this->sCart->updateDetail($cart_id, $product_id, $input);
            $hitung_total = $this->sCart->hitungTotal($cart_id);
            $input_update = array(
                'sub_total' => $hitung_total['sub_total'],
                'disc_price' => $hitung_total['disc_price'],
                'total' => $hitung_total['total'],
            );
            $updated = $this->sCart->update($cart_id, $input_update);
        }

        $cart = $this->sCart->findById($cart_id);
        $detail = $this->sCart->findDetailByIdProduct($cart_id, $product_id);
        $detail->stock = $this->sInventory->getStock($product_id, $detail->satuan_id);

        $data = array(
            'header' => $cart,
            'detail' => $detail,
        );
        return response()->json($data, 200);
    }
}

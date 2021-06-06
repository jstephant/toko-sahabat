<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Orders;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\TransactionStatus;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Hash;
use Image;

class SGlobal implements IGlobal
{
    private $product;
    private $purchase;
    private $orders;
    private $transactionStatus;
    private $cart;
    private $payment;

    public function __construct(Product $product, Purchase $purchase, Orders $orders,
        TransactionStatus $transactionStatus, Cart $cart, Payment $payment)
    {
        $this->product = $product;
        $this->purchase = $purchase;
        $this->orders = $orders;
        $this->transactionStatus = $transactionStatus;
        $this->cart = $cart;
        $this->payment = $payment;
    }

    public function curlAPI($type, $url, $request = null, $content_type = '', $headers = array())
    {
        $data = array(
			'content' => null,
			'error'	  => null
		);

        $curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_POST, 0);

        if($request) {
            if(empty($content_type)) $request = http_build_query($request, '', '&');
            if($content_type=='json') $request = json_encode($request);
        }

        if($type=='POST')
        {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $request);
        }

        if(count($headers)>0)
        {
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        }

		$response = curl_exec($curl);
        $err = curl_error($curl);
		curl_close($curl);

		$data['content'] = json_decode($response);
		$data['error'] = $err;

        return $data;
    }

    public function view($view = '', $data = array(), $overrideSession = true)
    {
        if (isset($data['title'])) {
            $data['title'] = $data['title'];
        } else {
            $data['title'] = 'Toko Imanuel';
        }

        if(env('APP_ENV') == 'production'){
            $data['asset'] = 'secure_asset';
        } else {
            $data['asset'] = 'asset';
        }

        if ($overrideSession) {
            session(['last_url' => URL::current()] );
        }

        return View::make($view, $data);
    }

    public function passwordEncrpt($password)
    {
        return Hash::make($password);
    }

    public function uploadImage($file, $destFolder)
    {
        $new_name = time() . '.' . $file->extension();
        $destinationPath = public_path('images/'.$destFolder.'/thumbnail');
        $img = Image::make($file->path());
        $img->resize(100, 100, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath.'/'.$new_name);

        $destinationPath = public_path('images/'.$destFolder);
        $img->resize(1024, 760, function($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath.'/'.$new_name);

        return $new_name;
    }

    public function generateCode($type, $table = null, $column = null, $length = 4)
    {
        $characters = '1234567890';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        if($type!='pin')
        {
            $check = $this->$table->where($column, $randomString)->first();

            if((isset($check->id) && $check->id != null) || strlen(intval($randomString))<$length){
                $randomString = $this->generateCode($type, $table, $column, $length);
            }
        }

        return $randomString;
    }

    public function getTransactionStatus($transaction_type)
    {
        return $this->transactionStatus->where($transaction_type, 1)->orderby('id', 'asc')->get();
    }
}

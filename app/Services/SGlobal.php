<?php

namespace App\Services;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Hash;

class SGlobal implements IGlobal
{
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
            $data['title'] = 'Toko Sahabat';
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
}

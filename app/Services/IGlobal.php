<?php

namespace App\Services;

interface IGlobal
{
    public function curlAPI($type, $url, $request=null, $content_type='', $headers=array());
    public function view($view = '', $data = array(), $overrideSession = true);
    public function passwordEncrpt($password);
    public function uploadImage($file, $destFolder);
    public function generateCode($type, $table=null, $column=null, $length = 4);
    public function getTransactionStatus($transaction_type);
}

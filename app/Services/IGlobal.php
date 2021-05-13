<?php

namespace App\Services;

interface IGlobal
{
    public function curlAPI($type, $url, $request=null, $content_type='', $headers=array());
    public function view($view = '', $data = array(), $overrideSession = true);
    public function passwordEncrpt($password);
    public function uploadImage($file, $destFolder);
}

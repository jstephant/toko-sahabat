<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Session;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function clearSession($key)
    {
        if (Session::has($key))
        {
            Session::forget($key);
        }
    }

    public function checkSession()
    {
        if(!Session::has('id')) {
            return redirect()->route('login');
        }
    }
}

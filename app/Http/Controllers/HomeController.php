<?php

namespace App\Http\Controllers;

use App\Services\SGlobal;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $sGlobal;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(SGlobal $sGlobal)
    {
        // $this->middleware('auth');
        $this->sGlobal = $sGlobal;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = array(
            'title'       => 'Dashboard',
            'active_menu' => 'Dashboard',
            'edit_mode'   => 1
        );
        return $this->sGlobal->view('dashboard.index', $data);
    }
}

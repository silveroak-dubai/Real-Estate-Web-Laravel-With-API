<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dashboard()
    {
        if(permission('dashboard-access')){
            $this->set_page_data('Dashboard');
            return view('home');
        }else{
            return $this->unauthorized_access_blocked();
        }
    }

    public function unauthorized()
    {
        $this->set_page_data('Unathorized Block','Unathorized Block');
        return view('unauthorized');
    }
}

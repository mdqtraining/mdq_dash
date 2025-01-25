<?php

namespace App\Http\Controllers;

use App\Models\Indicator;

class PerformanceController extends AccountBaseController
{
    
    
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'app.menu.paymentGatewayCredential';
        $this->activeSettingMenu = 'payment_gateway_settings';
    }
     
    public function indicator()
    {
        $this->pageTitle = 'app.menu.indicator';
        
      $indicator =   Indicator::select('*')->get();
        
        abort_403(!in_array('employee', user_roles()));
        return view('indicator.index', array_merge($this->data, ['indicator' => $indicator]));
    }
    public function appraisal()
    {
        $this->pageTitle = 'app.menu.appraisal';
        abort_403(!in_array('employee', user_roles()));
        return view('appraisal.index', $this->data);
    } 
    public function goaltracking()
    {
        $this->pageTitle = 'app.menu.goaltracking';
        abort_403(!in_array('employee', user_roles()));
        return view('goaltracking.index', $this->data);
    }   
    
}
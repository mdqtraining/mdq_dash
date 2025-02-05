<?php

namespace App\Http\Controllers;

use App\Models\Appraisal;
use App\Models\CompanyAddress;
use App\Models\Designation;
use App\Models\EmployeeDetails;
use App\Models\GoalTracking;
use App\Models\Indicator;
use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use QuickBooksOnline\API\Facades\Department;

class GoalTrackingController extends AccountBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'app.menu.paymentGatewayCredential';
        $this->activeSettingMenu = 'payment_gateway_settings';
    }
    public function goaltracking()
    {
        $this->pageTitle = 'app.menu.goaltracking';
        abort_403(!in_array('employee', user_roles()));
        $goaltracking = GoalTracking::select('*')->get();
        return view('goaltracking.index', array_merge($this->data, ['goaltracking' => $goaltracking]));
    }
    public function goaltrackingCreate()
    {
        $this->pageTitle = 'app.menu.goaltracking';
        abort_403(!in_array('employee', user_roles()));
        $goaltracking = GoalTracking::select('*')->get();
        return view('goaltracking.create', array_merge($this->data, ['goaltracking' => $goaltracking]));
    }  
    public function goaltrackingedit($id)
    {
        $this->pageTitle = 'edit goal tracking';
        abort_403(!in_array('employee', user_roles()));
        $goaltracking = GoalTracking::select('*')->get();
        return view('goaltracking.edit', array_merge($this->data,  ['goaltracking' => $goaltracking]));    
    }
}
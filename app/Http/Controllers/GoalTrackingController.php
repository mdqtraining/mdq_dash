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
use App\Models\Goal;
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
        $this->pageTitle = 'Add goaltracking';
        abort_403(!in_array('employee', user_roles()));
        $designation = Designation::pluck('name');
        $goals= Goal::pluck('name');
        $branchname = Company::pluck('company_name');
        return view('goaltracking.create', array_merge($this->data, ['designation' => $designation,'branchname' => $branchname,'goals' => $goals]));
    }  
    public function goaltrackingstore(Request $request)
    {
        $this->pageTitle = 'app.menu.goaltracking';
        abort_403(!in_array('employee', user_roles()));
        
        $request->validate([
            'branch' => 'required|string|max:255',
            'goal_type' => 'required|string|max:255',
            'start_date' => 'required|date|before_or_equal:end_date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'subject' => 'required|string|max:255',
            'target_achievement' => 'required|numeric',
            'description' => 'nullable|string|max:1000', // Validate description
        ]);

        // Store data in GoalTracking model
        GoalTracking::create([
            'goal_type' => $request->goal_type,
            'subject' => $request->subject,
            'branch' => $request->branch,
            'target_achievement' => $request->target,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'description' => $request->description, // Store description
        ]);
       
        // Redirect to a specific page with a success message
        return redirect()->route('goaltracking.index')->with('success', 'Goal Tracking Data Saved Successfully!');
    }  
    public function goaltrackingedit($id)
    {
        $this->pageTitle = 'edit goal tracking';
        abort_403(!in_array('employee', user_roles()));
        $goaltracking = GoalTracking::select('*')->get();
        return view('goaltracking.edit', array_merge($this->data,  ['goaltracking' => $goaltracking]));    
    }
    
}
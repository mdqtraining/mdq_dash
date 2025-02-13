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
    public function goaltracking(Request $request)
{
    $this->pageTitle = 'app.menu.goaltracking';
    abort_403(!in_array('employee', user_roles()));

    // Get filters from request
    $perPage = $request->input('per_page', 10);
    $branch = $request->input('branch');
    $goalType = $request->input('goal_type');
    $status = $request->input('status');

    // Initialize query
    $goaltracking = GoalTracking::query();

    if ($branch) {
        $goaltracking->where('branch', $branch);
    }

    if ($goalType) {
        $goaltracking->where('goal_type', $goalType);
    }

    if ($status) {
        $goaltracking->where('status', $status);
    }

    // Paginate results
    $goaltracking = $goaltracking->paginate($perPage);

    // Fetch related data for filters
    $branches = Company::select('company_name')->distinct()->get();
    $goalTypes = GoalTracking::select('goal_type')->distinct()->get();
    $statusOptions = ['Pending', 'In Progress', 'Completed']; // Example statuses

    return view('goaltracking.index', array_merge($this->data ?? [], [
        'goaltracking' => $goaltracking,
        'branches' => $branches,
        'goalTypes' => $goalTypes,
        'statusOptions' => $statusOptions
    ]));
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
            'target' => 'required|numeric',
            'description' => 'nullable|string|max:1000', // Validate description
        ]);
        // Store data in GoalTracking model
        GoalTracking::create([
            'goal_type' => $request->goal_type,
            'subject' => $request->subject,
            'branch' => $request->branch,
            'target' => $request->target,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'description' => $request->description,
            'created_at'=> now(),
        ]);
        return redirect()->route('goaltracking.index')->with('success', 'Goal Tracking Data Saved Successfully!');
    }  
    public function goaltrackingview($id)
    {
        $this->pageTitle = 'view goaltracking';
        abort_403(!in_array('employee', user_roles()));
        $goaltracking = GoalTracking::findOrFail($id);
        return view('goaltracking.view', array_merge($this->data, ['goaltracking' => $goaltracking]));
    }
    public function goaltrackingupdate(Request $request, $id)
    {
        $this->pageTitle = 'app.menu.goaltracking';
        abort_403(!in_array('employee', user_roles()));
    
        // Validate request data
        $request->validate([
            'branch' => 'required|string|max:255',
            'goal_type' => 'required|string|max:255',
            'start_date' => 'required|date|before_or_equal:end_date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'subject' => 'required|string|max:255',
            'target' => 'required|numeric',
            'description' => 'nullable|string|max:1000',
            'rating' => 'nullable|numeric|min:1|max:5',
            'progress' => 'nullable|numeric|min:0|max:100',
            'status' => 'nullable|string|max:255',
            ]);
    
        $goalTracking = GoalTracking::find($id);
            if (!$goalTracking) {
            return redirect()->route('goaltracking.index')->with('error', 'Goal Tracking Record Not Found.');
        }
    
        $goalTracking->update([
            'goal_type' => $request->goal_type,
            'subject' => $request->subject,
            'branch' => $request->branch,
            'target' => $request->target,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'description' => $request->description,
            'rating'=> $request->rating,
            'status' => $request->status,
            'updated_at' => now(),
            'progress' => $request->progress
        ]);
    
        return redirect()->route('goaltracking.index')->with('success', 'Goal Tracking Data Updated Successfully!');
    }
        public function goaltrackingdestroy($id)
  {
    $this->pageTitle = 'app.menu.goaltracking';
    
    // Ensure the user has the right role (if needed)
    abort_403(!in_array('employee', user_roles()));

    // Find the goal tracking record by ID
    $goalTracking = GoalTracking::find($id);
    
    // Check if the record exists
    if (!$goalTracking) {
        return redirect()->route('goaltracking.index')->with('error', 'Goal Tracking data not found!');
    }

    // Delete the goal tracking record
    $goalTracking->delete();

    // Redirect with a success message
    return redirect()->route('goaltracking.index')->with('success', 'Goal Tracking Data Deleted Successfully!');
   }

   
    public function goaltrackingedit($id)
    {
        $this->pageTitle = 'edit goal tracking';
        abort_403(!in_array('employee', user_roles()));
        $goaltracking = GoalTracking::findOrFail($id);
        $designation = Designation::pluck('name');
        $goals= Goal::pluck('name');
        $branchname = Company::pluck('company_name');
        return view('goaltracking.edit', array_merge($this->data,  ['goaltracking' => $goaltracking ,'designation' => $designation,'branchname' => $branchname,'goals' => $goals]));    
    }
    
}
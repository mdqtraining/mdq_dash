<?php

namespace App\Http\Controllers;

use App\Models\Appraisal;
use App\Models\GoalTracking;
use App\Models\Indicator;
use Illuminate\Http\Request;
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

    // Ensure user has the required role
    abort_403(!in_array('employee', user_roles()));

    // Fetch all indicators
    $indicators = Indicator::select('branch', 'department', 'designation', 'rating', 'added_by', 'created_at', 'id')->get();

    // Pass data to the view
    // return view('indicator.index', compact($this->data, ['indicators' => $indicators]));
    return view('indicator.index', array_merge($this->data, ['indicators' => $indicators]));
}

    public function appraisal()
    {
        

        $this->pageTitle = 'app.menu.appraisal';

        abort_403(!in_array('employee', user_roles()));

       
     $appraisals = Appraisal::select('*')->get();

     return view('appraisal.index', array_merge($this->data, ['appraisals' => $appraisals]));
    } 
    public function appraisalCreate()
    {
        

        $this->pageTitle = 'app.menu.appraisal';

        abort_403(!in_array('employee', user_roles()));

       
     $appraisals = Appraisal::select('*')->get();

     return view('appraisal.create', array_merge($this->data, ['appraisals' => $appraisals]));
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
    public function indicatorCreate()
    {
        $this->pageTitle = 'app.menu.addIndicator';
    
        // Ensure user has the required role
        abort_403(!in_array('employee', user_roles()));
    
        // Fetch all indicators
        $indicators = Indicator::select('*')->get();
    
        // Pass data to the view
        // return view('indicator.index', compact($this->data, ['indicators' => $indicators]));
        return view('indicator.create', array_merge($this->data, ['indicators' => $indicators]));
    }
    public function indicatorEdit()
    {
        $this->pageTitle = 'Edit Indicator';
    
        // Ensure user has the required role
        abort_403(!in_array('employee', user_roles()));
    $id = '1';
        // Fetch all indicators
        $indicators = Indicator::select('*')->get()->where('id',$id);
    
        // Pass data to the view
        // return view('indicator.index', compact($this->data, ['indicators' => $indicators]));
        return view('indicator.eidt', array_merge($this->data, ['indicators' => $indicators]));
    }
    // public function store(Request $request)
    // {
    //     // Validate the incoming data
    //     $data = $request->validate([
    //         'indicator_name' => 'required|string|max:255',
    //         'description' => 'nullable|string',
    //     ]);

    //     // Save the data in the database
    //     Indicator::create($data);

    //     // Redirect with a success message
    //     return redirect()->route('indicator.create')->with('success', 'Indicator added successfully!');
    // }
//     public function store(Request $request)
// {
//     // Validate the incoming data
//     $data = $request->validate([
       
//         'branch' => 'required|string|max:255',
//         'department' => 'required|string|max:255',
//         'designation' => 'required|string|max:255', // Assuming this is the user ID
//         'leadership' => 'nullable|numeric',
//         'project_management' => 'nullable|numeric',
//         'allocating_resources' => 'nullable|numeric',
//         'business_process' => 'nullable|numeric',
//         'oralcommunication' => 'nullable|numeric',
//     ]);

//     // Create a new indicator in the database
//     Indicator::create([
//         'branch' => $data['branch'],
//         'department' => $data['department'],
//         'designation' => $data['designation'],  
//         'leadership' => $data['leadership'] ?? null,
//         'project_management' => $data['project_management'] ?? null,
//         'allocating_resources' => $data['allocating_resources'] ?? null,
//         'business_process' => $data['business_process'] ?? null,
//         'oralcommunication' => $data['oralcommunication'] ?? null,
//     ]);

//     // Redirect with a success message
//     return redirect()->with('success', 'Indicator added successfully!');
// }

public function store(Request $request)
{
    // Your logic for storing the indicator, e.g.:
    $indicator = new Indicator();
    $indicator->branch = $request->input('branch_name');
    $indicator->save();

    // Flash the success message to the session
    session()->flash('success', 'Indicator added successfully!');

    // Return the current view with the flashed message
    return view('indicator.create', compact('indicator'));
}


    public function destroy($id)
{
    // Find the record by ID and delete it
    $indicator = Indicator::findOrFail($id);
    $indicator->delete();

    // Redirect with a success message
    return redirect()->route('indicator.create')->with('success', 'Indicator deleted successfully!');
}

     
}
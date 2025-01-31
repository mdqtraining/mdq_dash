<?php

namespace App\Http\Controllers;

use App\Models\Appraisal;
use App\Models\Designation;
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
    
        $designation = Designation::pluck('name'); // Extract only names
        return view('indicator.create', array_merge($this->data, ['designation' => $designation]));
         }
         public function indicatorEdit($id)
         {
             $this->pageTitle = 'Edit Indicator';
         
             // Ensure user has the required role
             abort_403(!in_array('employee', user_roles()));
         
             // Fetch the specific indicator
             $indicators = Indicator::findOrFail($id);
         
             // Fetch all designations (only name column)
             $designations = Designation::pluck('name');
         
             return view('indicator.edit', array_merge($this->data, [
                 'indicators' => $indicators,
                 'designations' => $designations
             ]));
         }
         public function indicatorUpdate($id)
         {
             $this->pageTitle = 'Edit Indicator';
         
             // Ensure user has the required role
             abort_403(!in_array('employee', user_roles()));
         
             // Fetch the specific indicator
             $indicators = Indicator::findOrFail($id);
         
             // Fetch all designations (only name column)
             $designations = Designation::pluck('name');
         
             return view('indicator.edit', array_merge($this->data, [
                 'indicators' => $indicators,
                 'designations' => $designations
             ]));
         }
         
         
  
    public function store(Request $request)
    {
        
        $request->validate([
            'branch' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            // 'designation' => 'required|string|max:255',
            'leadership' => 'required|numeric|min:1|max:5',
            'project_management' => 'required|numeric|min:1|max:5',
            'allocating_resources' => 'required|numeric|min:1|max:5',
            'business_process' => 'required|numeric|min:1|max:5',
            'oralcommunication' => 'required|numeric|min:1|max:5',
        ], [
            'branch.required' => 'Please enter the branch.',
            'department.required' => 'Please enter the department.',
            'designation.required' => 'Please enter the designation.',
            'leadership.required' => 'Leadership score is required.',
            'project_management.required' => 'Project Management score is required.',
            'allocating_resources.required' => 'Allocating Resources score is required.',
            'business_process.required' => 'Business Process score is required.',
            'oralcommunication.required' => 'Oral Communication score is required.',
        ]);
        
    
        // Create a new indicator in the database
        $data = new Indicator();
        $data->branch = $request['branch'];
        $data->department = $request['department'];
        $data->designation = $request['designation'];
        $data->leadership = $request['leadership'] ?? null;
        $data->project_management = $request['project_management'] ?? null;
        $data->allocating_resources = $request['allocating_resources'] ?? null;
        $data->business_process = $request['business_process'] ?? null;
        $data->oralcommunication = $request['oralcommunication'] ?? null;
        $data->save();
    
        // Flash success message and return
        return redirect()->route('indicator.success')->with('success', 'Indicator saved successfully');
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
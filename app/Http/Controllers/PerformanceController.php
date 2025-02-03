<?php

namespace App\Http\Controllers;

use App\Models\Appraisal;
use App\Models\CompanyAddress;
use App\Models\Designation;
use App\Models\EmployeeDetails;
use App\Models\GoalTracking;
use App\Models\Indicator;
use App\Models\User;
use Illuminate\Http\Request;
use QuickBooksOnline\API\Facades\Department;

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
        $employee=User::pluck('name');
        return view('appraisal.create', array_merge($this->data, [ 'employee' => $employee]));
    }
    public function getEmployeeIndicatorData(Request $request)
{
    $employeeId = $request->id;  // Get selected employee ID

    // Fetch employee details from the `users` table using the User model
    $employee = User::find($employeeId);

    if (!$employee) {
        return response()->json(['error' => 'Employee not found'], 404);
    }

    // Fetch role_id from the role_user table using the RoleUser model
    $designation = Designation::where('user_id', $employeeId)->first();

    if (!$designation) {
        return response()->json(['error' => 'Role not found for this employee'], 404);
    }
    // Fetch indicator data for the employee using the Indicator model
    $indicators = Indicator::where('designation', $designation)->get();
    dd($indicators);
    
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
        $branchname = CompanyAddress::pluck('location');
        $designation = Designation::pluck('name'); // Extract only names
        return view('indicator.create', array_merge($this->data, ['designation' => $designation ,'branchname' => $branchname] ));
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
    public function indicatorview($id)
    {
        $this->pageTitle = 'view Indicator';

        // Ensure user has the required role
        abort_403(!in_array('employee', user_roles()));

        // Fetch the specific indicator
        $indicators = Indicator::findOrFail($id);
        
        return view('indicator.view', array_merge($this->data, ['indicators' => $indicators]));
    }
    public function indicatorUpdate(Request $request, $id)
{
    // Validate input
    $request->validate([
        'branch' => 'required|string|max:255',
        'department' => 'required|string|max:255',
        'designation' => 'required|string|max:255',
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

    // Find the indicator
    $indicator = Indicator::findOrFail($id);

    // Calculate the rating
    $rating = (
        $request->oralcommunication +
        $request->leadership +
        $request->project_management +
        $request->allocating_resources +
        $request->business_process
    ) / 5;

    // Update fields correctly
    $indicator->branch = $request->branch;
    $indicator->department = $request->department;
    $indicator->designation = $request->designation;
    $indicator->leadership = $request->leadership;
    $indicator->project_management = $request->project_management;
    $indicator->allocating_resources = $request->allocating_resources;
    $indicator->business_process = $request->business_process;
    $indicator->oralcommunication = $request->oralcommunication;
    $indicator->rating = $rating; // explicitly set rating here

    // Save the changes
    $indicator->save();

    // Redirect with success message
    return redirect()->route('indicator.index')->with('success', 'Indicator updated successfully!');
}


    public function indicatorstore(Request $request)
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
        ]);      // Create a new indicator in the database
        $data = new Indicator();
        $data->branch = $request['branch'];
        $data->department = $request['department'];
        $data->designation = $request['designation'];
        $data->leadership = $request['leadership'] ?? null;
        $data->project_management = $request['project_management'] ?? null;
        $data->allocating_resources = $request['allocating_resources'] ?? null;
        $data->business_process = $request['business_process'] ?? null;
        $data->oralcommunication = $request['oralcommunication'] ?? null;
        $data->rating=($request['oralcommunication']+$request['leadership']+$request['project_management']+$request['allocating_resources']+$request['business_process'])/5;
        $data->save();

        // Flash success message and return
        return redirect()->route('indicator.index')->with('success', 'Indicator saved successfully');
    }


    public function appraisalstore(Request $request)
{
    $request->validate([
        'branch' => 'required|string|max:255',
        'department' => 'required|string|max:255',
        'designation' => 'required|string|max:255',
        'employee_name' => 'required|string|max:255',
        'appraisal_date' => 'required|date',
    ]);
    $data = new Appraisal();
   $data['branch'] = $request->branch;
   $data['department'] = $request->department;
   $data['designation'] = $request->designation;
   $data['employee_name'] = $request->employee_name;
   $data['appraisal_date'] = $request->appraisal_date;
    $data->save();

    return redirect()->back()->with('success', 'Appraisal record saved successfully.');
}


    public function indicatorDestroy($id)
    {
        $indicator = Indicator::findOrFail($id);
        $indicator->delete();
        return redirect()->route('indicator.index')->with('success', 'Indicator deleted successfully');
    }
}
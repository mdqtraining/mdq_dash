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
use App\Models\IndicatorfieldName;
use QuickBooksOnline\API\Facades\Department;
use Carbon\Carbon;

class AppraisalController extends AccountBaseController
{
    public function appraisal()
    {


        $this->pageTitle = 'app.menu.appraisal';

        abort_403(!in_array('employee', user_roles()));


        $appraisals = Appraisal::select('*')->get();

        return view('appraisal.index', array_merge($this->data, ['appraisals' => $appraisals]));
    }
    public function appraisalCreate()
    {
        $this->pageTitle = 'Add Appraisal';
        abort_403(!in_array('employee', user_roles()));
        $branchname = Company::pluck('company_name');
        $employee = User::pluck('name');
        $designations = Designation::pluck('name');
        $indicatorheaders = IndicatorfieldName::select('name', 'field_name')
            ->distinct()
            ->get()
            ->groupBy('name');
        return view('appraisal.create', array_merge($this->data, ['employee' => $employee, 'branchname' => $branchname, 'indicatorheaders' => $indicatorheaders,]));
    }
    public function appraisalstore(Request $request)
    {
        $request->validate([
            'branch' => 'required|string',
            'employee' => 'required|string',
            'monthYearPicker' => 'required|date_format:m/Y',
            'remarkInput' => 'nullable|string',
            'ratings' => 'required|array',
        ]);
    
        // Get branch and employee
        $branch = $request->input('branch');
        $employee = $request->input('employee');
    
        // Get company_id safely
        $company = Company::where('company_name', $branch)->first();
        if (!$company) {
            return response()->json(['error' => 'Company not found'], 404);
        }
        $company_id = $company->id;
    
        // Get user_id safely
        $user = User::where('name', $employee)->first();
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        $user_id = $user->id;
    
        // Get employee details
        $employee_details = EmployeeDetails::where('user_id', $user_id)
            ->where('company_id', $company_id)
            ->first();
        if (!$employee_details) {
            return response()->json(['error' => 'Employee details not found'], 404);
        }
    
        // Get designation
        $designation = Designation::find($employee_details->designation_id);
        if (!$designation) {
            return response()->json(['error' => 'Designation not found'], 404);
        }
    
        // Calculate overall rating
        $overallRating = array_sum($request->ratings) / count($request->ratings);
    
        // Define target rating (make sure this is properly set)
        $targetRating = 5; // Example value (update as needed)
    
        // Store appraisal
        $appraisal = new Appraisal();
        $appraisal->branch = $branch;
        $appraisal->designation = $designation->name;
        $appraisal->employee_name = $employee;
        $appraisal->target_rating = $targetRating;
        $appraisal->overall_rating = $overallRating;
        $appraisal->appraisal_date = Carbon::createFromFormat('m/Y', $request->monthYearPicker)->format('Y-m');
        $appraisal->remark = $request->remarkInput ?? null;
        $appraisal->created_at = now();
        $appraisal->updated_at = now();
        $appraisal->save();
    
        return redirect()->route('appraisal.index')->with('success', 'Appraisal saved successfully.');
    }
    
    public function getDesignation(Request $request)
    {
        $branch = $request->input('branch'); // or $request->json('branch')
        $employee = $request->input('employee'); // or $request->json('employee')
        $company_id = Company::where('company_name', $branch)->first()->id;
        if (empty($company_id)) {
            return response()->json(['error' => 'Company not found'], 404);
        }
        $user_id = User::where('name', $employee)->first()->id;
        if (empty($user_id)) {
            return response()->json(['error' => 'User not found'], 404);
        }
        $employee_details = EmployeeDetails::where('user_id', $user_id)
            ->where('company_id', $company_id)
            ->first();
        if (empty($employee_details)) {
            return response()->json(['error' => 'Employee details not found'], 404);
        }
        $designation = Designation::where('id', $employee_details->designation_id)->first()->name;
        if (empty($designation)) {
            return response()->json(['error' => 'Designation not found'], 404);
        }
        $indicators = Indicator::where('designation', $designation)
            ->where('branch', $branch)->get();
        if ($indicators) {
            return response()->json(['designation' => $indicators]);
        } else {
            return response()->json(['error' => 'indicators not found'], 404);
        }
    }
}

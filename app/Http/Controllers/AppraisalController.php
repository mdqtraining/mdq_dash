<?php

namespace App\Http\Controllers;

use App\Models\Appraisal;
use App\Models\CompanyAddress;
use App\Models\Designation;
use App\Models\EmployeeDetails;
use App\Models\GoalTracking;
use App\Models\Indicator;
use App\Models\User;
use App\Models\Team;
use App\Models\Company;
use App\Models\RoleUser;
use Illuminate\Http\Request;
use App\Models\IndicatorfieldName;
use Illuminate\Support\Facades\Auth;
use QuickBooksOnline\API\Facades\Department;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AppraisalExport;



class AppraisalController extends AccountBaseController
{
    public function appraisal(Request $request)
    {   
        $this->pageTitle = 'app.menu.appraisal';
        $user_id = Auth::user()->id;
        $user_name = Auth::user()->name;
        $role_id = RoleUser::where('user_id', $user_id)->value('role_id'); // Get role as integer
    
        $perPage = $request->input('per_page', 10);
    
        // Default empty paginated collection
        $appraisals = Appraisal::paginate($perPage); // This ensures pagination is always applied
    
        $employees = collect();
        $departments = collect();
        $designations = collect();
        $branches = collect();
    
        if ($role_id == 1) { // Admin
            $query = Appraisal::query();
    
            if ($request->filled('employee')) {
                $query->where('employee_name', $request->employee);
            }
            if ($request->filled('department')) {
                $query->where('department', $request->department);
            }
            if ($request->filled('designation')) {
                $query->where('designation', $request->designation);
            }
            if ($request->filled('branch')) {
                $query->where('branch', $request->branch);
            }
    
            $appraisals = $query->paginate($perPage); // ✅ Always paginate
    
            // Get filter options
            $employees = Appraisal::select('employee_name')->distinct()->get();
            $departments = Appraisal::select('department')->distinct()->whereNotNull('department')->get();
            $designations = Appraisal::select('designation')->distinct()->whereNotNull('designation')->get();
            $branches = Appraisal::select('branch')->distinct()->whereNotNull('branch')->get();
            return view('appraisal.index', array_merge($this->data, [
                'appraisals' => $appraisals,
                'employees' => $employees,
                'departments' => $departments,
                'designations' => $designations,
                'branches' => $branches,
                'role_id' => $role_id
            ]));
        }
        elseif ($role_id == 2) { // Employee 
            $appraisals = Appraisal::where('employee_name', $user_name)->paginate($perPage);
            return view('appraisal.index', array_merge($this->data, [
                'appraisals' => $appraisals,
                'employees' => $employees,
                'departments' => $departments,
                'designations' => $designations,
                'branches' => $branches,
                'role_id' => $role_id
            ]));
        }
        
      
    }
    public function export()
    {
        return Excel::download(new AppraisalExport, 'appraisals.xlsx');
    }
    public function appraisalCreate()
    {
        $this->pageTitle = 'Add Appraisal';
        abort_403(!in_array('employee', user_roles()));
        $branchname = Indicator::distinct()->pluck('branch')->toArray();
        $department = Indicator::distinct()->pluck('department')->toArray();
        $designation = Indicator::distinct()->pluck('designation')->toArray();
        $branch_id = Company::whereIn('company_name', $branchname)->pluck('id')->toArray();
        $department_id = Team::whereIn('team_name', $department)->pluck('id')->toArray();
        $designation_id = Designation::whereIn('name', $designation)
            ->whereIn('company_id', $branch_id)
            ->pluck('id')
            ->toArray();
        $employees = EmployeeDetails::whereIn('company_id', $branch_id)
            ->whereIn('department_id', $department_id)
            ->whereIn('designation_id', $designation_id)
            ->pluck('user_id')
            ->toArray();
        $employee = User::whereIn('id', $employees)
            ->pluck('name')
            ->toArray();
        $indicatorheaders = IndicatorfieldName::select('name', 'field_name')
            ->distinct()
            ->get()
            ->groupBy('name');
        return view('appraisal.create', array_merge($this->data, ['employee' => $employee, 'branchname' => $branchname, 'indicatorheaders' => $indicatorheaders, 'department' => $department]));
    }
    public function appraisalupdate(Request $request, $id)
    {
        $validated = $request->validate([
            'branch' => 'required|string',
            'employee' => 'required|string',
            'month_year' => 'required|string',
            'remark' => 'nullable|string',
            'ratings' => 'required|array',
            'department' => 'required|string',
        ]);

        $branch = $request->input('branch');
        $company = Company::where('company_name', $branch)->first();
        if (!$company) {
            return redirect()->back()->with('error', 'Company not found. Please select a valid branch.');
        }
        $company_id = $company->id;

        $employee = $request->input('employee');
        $user = User::where('name', $employee)->first();
        if (!$user) {
            return redirect()->back()->with('error', 'Employee not found. Please select a valid employee.');
        }
        $user_id = $user->id;

        // Fetch Employee Details
        $employee_details = EmployeeDetails::where('user_id', $user_id)
            ->where('company_id', $company_id)
            ->first();
        if (!$employee_details) {
            return redirect()->back()->with('error', 'Employee details are missing for the selected branch.');
        }

        // Fetch Designation
        $designation_id = $employee_details->designation_id;
        $designation = Designation::where('id', $designation_id)->value('name');
        if (!$designation) {
            return redirect()->back()->with('error', 'Designation not found for the selected employee.');
        }

        // Fetch Indicators
        $indicator = Indicator::where('designation', $designation)
            ->where('branch', $branch)
            ->first();

        if (!$indicator) {
            return redirect()->back()->with('error', 'No performance indicator found for this designation and branch.');
        }

        $targetRating = $indicator->rating;

        // Calculate Ratings
        $ratings = $request->input('ratings');
        $overallRating = array_sum($ratings) / count($ratings);

        // Fetch existing appraisal
        $appraisal = Appraisal::findOrFail($id);

        // Update fields
        $appraisal->branch = $branch;
        $appraisal->designation = $designation;
        $appraisal->employee_name = $employee;
        $appraisal->target_rating = $targetRating;
        $appraisal->field_ratings = json_encode($ratings); // ✅ Save ratings correctly
        $appraisal->overall_rating = $overallRating;
        $appraisal->appraisal_date = Carbon::createFromFormat('m/Y', $request->month_year)->format('Y-m'); // ✅ Fixed
        $appraisal->remark = $request->remark ?? null;
        $appraisal->department = $request->department;
        $appraisal->updated_at = now();
        $appraisal->save();

        return redirect()->route('appraisal.index')->with('success', 'Appraisal updated successfully.');
    }

    public function appraisaledit($id)
    {
        $this->pageTitle = 'Edit Appraisal';
        abort_403(!in_array('employee', user_roles()));
        $appraisal = Appraisal::findOrFail($id);
        $branch = $appraisal->branch;
        $depart = $appraisal->department;
        $designation = $appraisal->designation;
        $indicator = Indicator::where('branch', $branch)->where('department', $depart)->where('designation', $designation)->get();
        $branchname = Company::pluck('company_name');
        $employee = User::pluck('name');
        $department = Team::pluck('team_name');
        $designations = Designation::pluck('name');
        $indicatorheaders = IndicatorfieldName::select('name', 'field_name')
            ->distinct()
            ->get()
            ->groupBy('name');
        return view('appraisal.edit', array_merge($this->data, ['appraisal' => $appraisal, 'employee' => $employee, 'branchname' => $branchname, 'indicatorheaders' => $indicatorheaders, 'designations' => $designations, 'department' => $department, 'indicator' => $indicator]));
    }
    public function appraisalview($id)
    {
        $this->pageTitle = 'view Appraisal';
        abort_403(!in_array('employee', user_roles()));
        $user_id = Auth::user()->id;
        $role_id = RoleUser::where('user_id', $user_id)->value('role_id');
        $appraisal = Appraisal::findOrFail($id);
        $branch = $appraisal->branch;
        $depart = $appraisal->department;
        $designation = $appraisal->designation;
        $indicator = Indicator::where('branch', $branch)->where('department', $depart)->where('designation', $designation)->get();
        $branchname = Company::pluck('company_name');
        $employee = User::pluck('name');
        $department = Team::pluck('team_name');
        $designations = Designation::pluck('name');
        $indicatorheaders = IndicatorfieldName::select('name', 'field_name')
            ->distinct()
            ->get()
            ->groupBy('name');
        return view('appraisal.view', array_merge($this->data, ['appraisal' => $appraisal, 'employee' => $employee, 'branchname' => $branchname, 'indicatorheaders' => $indicatorheaders, 'designations' => $designations, 'department' => $department, 'role_id' => $role_id, 'indicator' => $indicator]));
    }
    public function appraisalstore(Request $request)
    {
        $validated = $request->validate([
            'branch' => 'required|string',
            'employee' => 'required|string',
            'month_year' => 'required|string',
            'remark' => 'nullable|string',
            'ratings' => 'required|array',
            'department' => 'required|string',
        ]);

        $branch = $request->input('branch');
        $company = Company::where('company_name', $branch)->first();
        if (!$company) {
            return redirect()->back()->with('error', 'Company not found. Please select a valid branch.');
        }
        $company_id = $company->id;

        $employee = $request->input('employee');
        $user = User::where('name', $employee)->first();
        if (!$user) {
            return redirect()->back()->with('error', 'Employee not found. Please select a valid employee.');
        }
        $user_id = $user->id;

        // Fetch Employee Details
        $employee_details = EmployeeDetails::where('user_id', $user_id)
            ->where('company_id', $company_id)
            ->first();
        if (!$employee_details) {
            return redirect()->back()->with('error', 'Employee details are missing for the selected branch.');
        }

        // Fetch Designation
        $designation_id = $employee_details->designation_id;
        $designation = Designation::where('id', $designation_id)->value('name');
        if (!$designation) {
            return redirect()->back()->with('error', 'Designation not found for the selected employee.');
        }

        // Fetch Indicators
        $indicator = Indicator::where('designation', $designation)
            ->where('branch', $branch)
            ->first();

        if (!$indicator) {
            return redirect()->back()->with('error', 'No performance indicator found for this designation and branch.');
        }

        $targetRating = $indicator->rating;

        // Calculate Ratings
        $ratings = $request->input('ratings');
        $overallRating = array_sum($ratings) / count($ratings);

        // Store Data
        $appraisal = new Appraisal();
        $appraisal->branch = $branch;
        $appraisal->designation = $designation;
        $appraisal->employee_name = $employee;
        $appraisal->target_rating = $targetRating;
        $appraisal->field_ratings = json_encode($ratings); // ✅ Save ratings correctly
        $appraisal->overall_rating = $overallRating;
        $appraisal->appraisal_date = Carbon::createFromFormat('m/Y', $request->month_year)->format('Y-m'); // ✅ Fixed
        $appraisal->remark = $request->remark ?? null;
        $appraisal->created_at = now();
        $appraisal->department = $request->department;
        $appraisal->updated_at = now();
        $appraisal->save();

        return redirect()->route('appraisal.index')->with('success', 'Appraisal saved successfully.');
    }

    public function appraisalDestroy($id)
    {
        $appraisal = Appraisal::findOrFail($id);
        $appraisal->delete();
        return redirect()->route('appraisal.index')->with('success', 'Appraisal deleted successfully');
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

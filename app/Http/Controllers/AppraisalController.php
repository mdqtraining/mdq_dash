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
        $employee=User::pluck('name');
        $designations = Designation::pluck('name');
        $indicatorheaders = IndicatorfieldName::select('name', 'field_name')
            ->distinct()
            ->get()
            ->groupBy('name');
        return view('appraisal.create', array_merge($this->data, [ 'employee' => $employee,'branchname'=>$branchname ,'indicatorheaders' => $indicatorheaders ,]));
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
        $designation = Designation ::where('id', $employee_details->designation_id)->first()->name;
        if (empty($designation)) {
            return response()->json(['error' => 'Designation not found'], 404);
        }
        $indicators = Indicator::where('designation', $designation)
                                ->where('branch', $branch)->get();
        if ($indicators) {
            return response()->json(['designation' => $indicators]);
        } 
        else {
            return response()->json(['error' => 'indicators not found'], 404);
        }
    }    
}

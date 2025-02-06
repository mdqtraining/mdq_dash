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
        $employee=User::pluck('name');
        return view('appraisal.create', array_merge($this->data, [ 'employee' => $employee]));
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
    
     
}

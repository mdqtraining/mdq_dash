<?php

namespace App\Http\Controllers;

use App\Models\Indicator;
use App\Models\User;
use App\Models\Company;
use App\Models\Designation;
use Illuminate\Http\Request;

class IndicatorController extends AccountBaseController
{
    public function indicator()
    {
        $this->pageTitle = 'app.menu.indicator';
        abort_403(!in_array('employee', user_roles()));

        $indicators = Indicator::select('branch', 'department', 'designation', 'rating', 'added_by', 'created_at', 'id')->get();

        return view('indicator.index', array_merge($this->data, ['indicators' => $indicators]));
    }

    public function getEmployeeIndicatorData(Request $request)
    {
        $employeeId = $request->id;
        $employee = User::find($employeeId);

        if (!$employee) {
            return response()->json(['error' => 'Employee not found'], 404);
        }

        $designation = Designation::where('user_id', $employeeId)->first();

        if (!$designation) {
            return response()->json(['error' => 'Role not found for this employee'], 404);
        }

        $indicators = Indicator::where('designation', $designation)->get();
    }

    public function indicatorCreate()
    {
        $this->pageTitle = 'app.menu.addIndicator';
        abort_403(!in_array('employee', user_roles()));

        $branchname = Company::pluck('company_name');
        $designation = Designation::pluck('name');

        return view('indicator.create', array_merge($this->data, ['designation' => $designation, 'branchname' => $branchname]));
    }

    public function indicatorEdit($id)
    {
        $this->pageTitle = 'Edit Indicator';
        abort_403(!in_array('employee', user_roles()));

        $indicators = Indicator::findOrFail($id);
        $designations = Designation::pluck('name');

        return view('indicator.edit', array_merge($this->data, [
            'indicators' => $indicators,
            'designations' => $designations
        ]));
    }

    public function indicatorView($id)
    {
        $this->pageTitle = 'View Indicator';
        abort_403(!in_array('employee', user_roles()));

        $indicators = Indicator::findOrFail($id);

        return view('indicator.view', array_merge($this->data, ['indicators' => $indicators]));
    }

    public function indicatorUpdate(Request $request, $id)
    {
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

        $indicator = Indicator::findOrFail($id);

        $rating = (
            $request->oralcommunication +
            $request->leadership +
            $request->project_management +
            $request->allocating_resources +
            $request->business_process
        ) / 5;

        $indicator->update([
            'branch' => $request->branch,
            'department' => $request->department,
            'designation' => $request->designation,
            'leadership' => $request->leadership,
            'project_management' => $request->project_management,
            'allocating_resources' => $request->allocating_resources,
            'business_process' => $request->business_process,
            'oralcommunication' => $request->oralcommunication,
            'rating' => $rating
        ]);

        return redirect()->route('indicator.index')->with('success', 'Indicator updated successfully!');
    }

    public function indicatorStore(Request $request)
    {
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

        $rating = (
            $request->oralcommunication +
            $request->leadership +
            $request->project_management +
            $request->allocating_resources +
            $request->business_process
        ) / 5;

        Indicator::create([
            'branch' => $request->branch,
            'department' => $request->department,
            'designation' => $request->designation,
            'leadership' => $request->leadership,
            'project_management' => $request->project_management,
            'allocating_resources' => $request->allocating_resources,
            'business_process' => $request->business_process,
            'oralcommunication' => $request->oralcommunication,
            'rating' => $rating
        ]);

        return redirect()->route('indicator.index')->with('success', 'Indicator saved successfully');
    }

    public function indicatorDestroy($id)
    {
        $indicator = Indicator::findOrFail($id);
        $indicator->delete();

        return redirect()->route('indicator.index')->with('success', 'Indicator deleted successfully');
    }
}

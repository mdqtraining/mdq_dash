<?php

namespace App\Http\Controllers;

use App\Models\Indicator;
use App\Models\User;
use App\Models\Company;
use App\Models\Designation;
use App\Models\Team;
use Illuminate\Support\Str;
use App\Models\IndicatorfieldName;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class IndicatorController extends AccountBaseController
{
    public function indicator(Request $request)
    {
        $this->pageTitle = 'app.menu.indicator';
        abort_403(!in_array('employee', user_roles()));
    
        $perPage = $request->input('per_page', 10); // Get per_page from request, default to 10
        $indicators = Indicator::select('branch', 'department', 'designation', 'rating', 'added_by', 'created_at', 'id')
            ->paginate($perPage);
    
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
    
        // Fetch branch names
        $branchname = Company::pluck('company_name');
    
        // Fetch designations
        $designation = Designation::pluck('name');
        $department= Team::pluck('team_name');
    
        // Fetch indicator headers grouped by category (name)
        $indicatorheaders = IndicatorfieldName::select('name', 'field_name')
            ->distinct()
            ->get()
            ->groupBy('name');
    
        return view('indicator.create', array_merge($this->data, [
            'designation' => $designation,
            'branchname' => $branchname,
            'indicatorheaders' => $indicatorheaders,
            'department'=> $department
        ]));
    }
    

    public function indicatorEdit($id)
    {
        $this->pageTitle = 'Edit Indicator';
        abort_403(!in_array('employee', user_roles()));

        $indicators = Indicator::findOrFail($id);
        $designations = Designation::pluck('name');
        $branchname = Company::pluck('company_name');
        $departments = Team::pluck('team_name');
        $indicatorheaders = IndicatorfieldName::select('name', 'field_name')
            ->distinct()
            ->get()
            ->groupBy('name');
        return view('indicator.edit', array_merge($this->data, [
            'indicators' => $indicators,
            'designations' => $designations
            , 'branchname' => $branchname
            , 'indicatorheaders' => $indicatorheaders,
            'departments' => $departments
        ]));
    }

    public function indicatorView($id)
    {
        $this->pageTitle = 'View Indicator';
        abort_403(!in_array('employee', user_roles()));
        $indicators = Indicator::findOrFail($id);
        $indicatorheaders = IndicatorfieldName::select('name', 'field_name')
            ->distinct()
            ->get()
            ->groupBy('name');
        return view('indicator.view', array_merge($this->data, ['indicators' => $indicators,
            'indicatorheaders' => $indicatorheaders]));
    }

    
    public function indicatorUpdate(Request $request, $id)
        {
    // Validate incoming request
    $request->validate([
        'branch' => 'required|string|max:255',
        'department' => 'required|string|max:255',
        'designation' => 'required|string|max:255',
    ]);

    // Fetch field names dynamically from IndicatorfieldName table
    $fieldNames = IndicatorfieldName::select('field_name')->distinct()->pluck('field_name');

    // Prepare the ratings array from the submitted form
    $ratings = [];

    // Generate custom validation rules for the ratings
    $validationRules = [];
    foreach ($fieldNames as $fieldName) {
        $fieldSlug = Str::slug($fieldName, '_');
        // Add validation rule for each rating field
        $validationRules['ratings.' . $fieldSlug] = 'required|numeric|min:1|max:5';
        
        // Fetch the rating value from the form using the slug of field_name as the key
        $ratings[$fieldName] = $request->input('ratings.' . $fieldSlug);
    }

    // Validate the ratings array dynamically
    $request->validate($validationRules);

    // Calculate the average rating if needed
    $rating = array_sum($ratings) / count($ratings);

    // Find the indicator entry by its ID
    $indicator = Indicator::find($id);

    if (!$indicator) {
        // If the indicator doesn't exist, redirect back with an error
        return redirect()->back()->with('error', 'Indicator not found');
    }

    // Update the indicator with new data
    $indicator->update([
        'branch' => $request->branch,
        'department' => $request->department,
        'designation' => $request->designation,
        'field_names' => json_encode($fieldNames->toArray()), // Store field names as JSON
        'field_ratings' => json_encode($ratings), // Store ratings as JSON
        'rating' => $rating, // Store the average rating if you need it
        'updated_by' => Auth::user()->name, // Store who updated the record
    ]);

    // Redirect to the indicator list page with a success message
    return redirect()->route('indicator.index')->with('success', 'Indicator updated successfully');
    }

    public function indicatorStore(Request $request)
    {
     // Validate incoming request
     $request->validate([
        'branch' => 'required|string|max:255',
        'department' => 'required|string|max:255',
        'designation' => 'required|string|max:255',
        ]);

        // Fetch field names dynamically from IndicatorfieldName table
        $fieldNames = IndicatorfieldName::select('field_name')->distinct()->pluck('field_name');

        // Prepare the ratings array from the submitted form
        $ratings = [];
    
        // Generate custom validation rules for the ratings
        $validationRules = [];
        foreach ($fieldNames as $fieldName) {
        $fieldSlug = Str::slug($fieldName, '_');
        // Add validation rule for each rating field
        $validationRules['ratings.' . $fieldSlug] = 'required|numeric|min:1|max:5';
        
        // Fetch the rating value from the form using the slug of field_name as the key
        $ratings[$fieldName] = $request->input('ratings.' . $fieldSlug);
        }

        // Validate the ratings array dynamically
        $request->validate($validationRules);

        // Calculate the average rating if needed
        $rating = array_sum($ratings) / count($ratings);


        // Check if the data already exists in the database
        $dataAlready = Indicator::where('branch', $request->branch)
                            ->where('department', $request->department)
                            ->where('designation', $request->designation)
                            ->first();

        if ($dataAlready) {
        // If data exists, redirect with an error
        $indicator = $dataAlready->id;
        return redirect()->back()->with('error', 'Indicator already exists')->with('indicator', $indicator);
        } else {
        // Save new indicator along with ratings as JSON arrays
        Indicator::create([
            'branch' => $request->branch,
            'department' => $request->department,
            'designation' => $request->designation,
            'field_names' => json_encode($fieldNames->toArray()), // Store field names as JSON
            'field_ratings' => json_encode($ratings), // Store ratings as JSON
            'rating' => $rating, // Store the average rating if you need it
            'added_by' => Auth::user()->name,
        ]);

        return redirect()->route('indicator.index')->with('success', 'Indicator saved successfully');
        }
    }


    public function indicatorDestroy($id)
    {
        $indicator = Indicator::findOrFail($id);
        $indicator->delete();

        return redirect()->route('indicator.index')->with('success', 'Indicator deleted successfully');
    }
}

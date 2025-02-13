<form method="GET" action="{{ route('appraisal.index') }}">
    <div class="d-lg-flex d-md-flex d-block flex-wrap filter-box bg-white client-list-filter">
        <!-- Employee Filter -->
        <div class="select-box d-flex py-2 px-lg-2 px-md-2 px-0 border-right-grey border-right-grey-sm-0 align-items-center">
            <p class="mb-0 pr-2 f-14 text-dark-grey d-flex align-items-center">@lang('app.employee')</p>
            <div class="select-status">
                <select class="form-control select-picker" name="employee" id="employee" data-live-search="true">
                    <option value="">All Employees</option>
                    @foreach ($employees as $employee)
                        <option value="{{ $employee->employee_name }}" {{ request('employee') == $employee->employee_name ? 'selected' : '' }}>
                            {{ $employee->employee_name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Deportment Filter -->
        <div class="select-box d-flex py-2 px-lg-2 px-md-2 px-0 border-right-grey border-right-grey-sm-0 align-items-center">
            <p class="mb-0 pr-2 f-14 text-dark-grey d-flex align-items-center">department</p>
            <div class="select-status">
                <select class="form-control select-picker" name="department" id="department" data-live-search="true">
                    <option value="">All Departments</option>
                    @foreach ($departments as $department)
                        <option value="{{ $department->department }}" {{ request('department') == $department->department ? 'selected' : '' }}>
                            {{ $department->department }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
            
        <!-- designation Filter --> 
        <div class="select-box d-flex py-2 px-lg-2 px-md-2 px-0 border-right-grey border-right-grey-sm-0 align-items-center">
            <p class="mb-0 pr-2 f-14 text-dark-grey d-flex align-items-center">designation</p>
            <div class="select-status">
                <select class="form-control select-picker" name="designation" id="designation" data-live-search="true">
                    <option value="">All Designations</option>
                    @foreach ($designations as $designation)
                        <option value="{{ $designation->designation }}" {{ request('designation') == $designation->designation ? 'selected' : '' }}>
                            {{$designation->designation}}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <div class="select-box d-flex align-items-center py-2 px-2">
                <button type="submit" class="btn btn-primary btn-xs">
                    <i class="fa fa-filter"></i> Filter
                </button>
                <a href="{{ route('appraisal.index') }}"  class="btn btn-secondary btn-xs ml-2">
                    <i class="fa fa-times-circle"></i> @lang('app.clearFilters')
                </a>
            </div>
        <!-- Submit Button -->
        
    </div>
</form>

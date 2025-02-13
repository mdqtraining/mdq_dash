<form method="GET" action="{{ route('indicator.index') }}">
    <div class="filter-box">
        <div class="d-lg-flex d-md-flex d-block flex-wrap filter-box bg-white client-list-filter align-items-center">
            
            <!-- 🔹 Branch Filter -->
            <div class="select-box d-flex align-items-center pr-2 border-right-grey border-right-grey-sm-0 py-2 px-2">
                <p class="mb-0 pr-2 f-14 text-dark-grey d-flex align-items-center">Branch</p>
                <div class="select-status d-flex align-items-center">
                    <select class="form-control select-picker" name="branch">
                        <option value="">@lang('app.all')</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->company_name }}" {{ request('branch') == $branch->companyname ? 'selected' : '' }}>{{ $branch->company_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            

            <!-- 🔹 Department Filter -->
            <div class="select-box d-flex align-items-center pr-2 border-right-grey border-right-grey-sm-0 py-2 px-2">
                <p class="mb-0 pr-2 f-14 text-dark-grey d-flex align-items-center">@lang('app.department')</p>
                <div class="select-status d-flex align-items-center">
                    <select class="form-control select-picker" name="department">
                        <option value="">@lang('app.all')</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->team_name }}" {{ request('department') == $department->team_name ? 'selected' : '' }}>{{ $department->team_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- 🔹 Designation Filter -->
            <div class="select-box d-flex align-items-center pr-2 border-right-grey border-right-grey-sm-0 py-2 px-2">
                <p class="mb-0 pr-2 f-14 text-dark-grey d-flex align-items-center">@lang('app.designation')</p>
                <div class="select-status d-flex align-items-center">
                    <select class="form-control select-picker" name="designation">
                        <option value="">@lang('app.all')</option>
                        @foreach($designations as $designation)
                            <option value="{{ $designation->name }}" {{ request('designation') == $designation->name ? 'selected' : '' }}>{{ $designation->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- 🔹 Rating Filter -->
            <div class="select-box d-flex align-items-center pr-2 border-right-grey border-right-grey-sm-0 py-2 px-2">
                <p class="mb-0 pr-2 f-14 text-dark-grey d-flex align-items-center">@lang('app.rating')</p>
                <div class="select-status d-flex align-items-center">
                    <select class="form-control select-picker" name="rating">
                        <option value="">@lang('app.all')</option>
                        <option value="1" {{ request('rating') == '1' ? 'selected' : '' }}>1 Star</option>
                        <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>2 Stars</option>
                        <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>3 Stars</option>
                        <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>4 Stars</option>
                        <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>5 Stars</option>
                    </select>
                </div>
            </div>

            <!-- 🔹 Buttons -->
            <div class="select-box d-flex align-items-center py-2 px-2">
                <button type="submit" class="btn btn-primary ">
                    <i class="fa fa-filter"></i> Filter
                </button>
                <a href="{{ route('indicator.index') }}" class="btn btn-secondary ml-2 ">
                    <i class="fa fa-times-circle"></i> @lang('app.clearFilters')
                </a>
            </div>

        </div>
    </div>
</form>

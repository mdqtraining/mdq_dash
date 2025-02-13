<form method="GET" action="{{ route('goaltracking.index') }}">
    <div class="filter-box">
        <div class="d-lg-flex d-md-flex d-block flex-wrap filter-box bg-white client-list-filter align-items-center">
            
            <!-- 🔹 Branch Filter -->
            <div class="select-box d-flex align-items-center pr-2 border-right-grey border-right-grey-sm-0 py-2 px-2">
                <p class="mb-0 pr-2 f-14 text-dark-grey d-flex align-items-center">Branch</p>
                <div class="select-status d-flex align-items-center">
                    <select class="form-control select-picker" name="branch">
                        <option value="">@lang('app.all')</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->company_name }}" {{ request('branch') == $branch->company_name ? 'selected' : '' }}>{{ $branch->company_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- 🔹 Goal Type Filter -->
            <div class="select-box d-flex align-items-center pr-2 border-right-grey border-right-grey-sm-0 py-2 px-2">
                <p class="mb-0 pr-2 f-14 text-dark-grey d-flex align-items-center">Goal Type</p>
                <div class="select-status d-flex align-items-center">
                    <select class="form-control select-picker" name="goal_type">
                        <option value="">@lang('app.all')</option>
                        @foreach($goalTypes as $goalType)
                            <option value="{{ $goalType->goal_type }}" {{ request('goal_type') == $goalType->goal_type ? 'selected' : '' }}>{{ $goalType->goal_type }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- 🔹 Status Filter (Replaced Progress) -->
            <div class="select-box d-flex align-items-center pr-2 border-right-grey border-right-grey-sm-0 py-2 px-2">
                <p class="mb-0 pr-2 f-14 text-dark-grey d-flex align-items-center">Status</p>
                <div class="select-status d-flex align-items-center">
                    <select class="form-control select-picker" name="status">
                        <option value="">@lang('app.all')</option>
                        @foreach($statusOptions as $status)
                            <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <!-- 🔹 Buttons -->
            <div class="select-box d-flex align-items-center py-2 px-2">
                <button type="submit" class="btn btn-primary ">
                    <i class="fa fa-filter"></i> Filter
                </button>
                <a href="{{ route('goaltracking.index') }}" class="btn btn-secondary ml-2 ">
                    <i class="fa fa-times-circle"></i> @lang('app.clearFilters')
                </a>
            </div>
        </div>
    </div>
</form>

@if (in_array('lead', $activeWidgets) && $leadAgent && in_array('leads', user_modules()))
    <div class="col-md-6 mb-3">
        <div
            class="bg-white p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center mt-3 mt-lg-0 mt-md-0">
            <div class="d-block">
                <i class="bi bi-person text-white f-27" style="background-color:#ff3a6e; padding: 5px 5px; border-radius:10px;"></i>
            </div>
            <div class="d-block text-capitalize">
                <h5 class="f-15 f-w-500 mb-20 text-darkest-grey"> @lang('app.menu.lead') </h5>
                <div class="d-flex">
                    <a href="{{ route('leads.index') . '?assignee=me&type=lead' }}">
                        <p class="mb-0 f-21 font-weight-bold text-red d-grid mr-5">
                            {{ $totalLead }}<span
                                class="f-12 font-weight-normal text-lightest">@lang('app.total') @lang('app.menu.leads')</span>
                        </p>
                    </a>

                    <a href="{{ route('leads.index') . '?assignee=me&type=client' }}">
                        <p class="mb-0 f-21 font-weight-bold text-light-green d-grid">
                            {{ $convertedLead }}<span
                                class="f-12 font-weight-normal text-lightest">@lang('modules.lead.convertedLead')</span>
                        </p>
                    </a>
                </div>
            </div>
            
        </div>
    </div>
@endif

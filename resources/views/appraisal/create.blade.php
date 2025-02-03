@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('vendor/full-calendar/main.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/css/bootstrap-colorpicker.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@push('datatable-styles')
    @include('sections.daterange_css')
@endpush

@section('content')
<form action="{{ route('appraisal.store') }}" method="POST" id="appraisalForm">
    @csrf
    <div class="content-wrapper">
        <div class="add-page">
            <div class="p-20">
                <h4 class="mb-0 p-20 f-21 font-weight-normal text-capitalize border-bottom-grey">
                    @lang('app.menu.indicatorDetials')
                </h4>
                <div class="row p-20">
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group my-3">
                            <label class="f-14 text-dark-grey mb-12">Branch <sup class="f-14 mr-1">*</sup></label>
                            <input type="text" class="form-control height-35 f-14" placeholder="Branch" name="branch"
                                id="branch" required>
                            @error('branch')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group my-3">
                            <label class="f-14 text-dark-grey mb-12">Employee <sup class="f-14 mr-1">*</sup></label>
                            <select class="form-control height-35 f-14" name="employee" id="employee" required>
                                <option value="" disabled selected>Select employee</option>
                                @foreach($employee as $item)
                                    <option>{{ $item }}</option>
                                @endforeach
                            </select>
                            @error('employee')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4" id="deadlineBox">
                    <label for="monthYearPicker" class="f-14 text-dark-grey mb-12">Select Month and Year <sup
                            class="f-14 mr-1">*</sup></label>
                    <input type="text" id="monthYearPicker" class="form-control height-35 f-14 bg-white"
                        placeholder="MM/YYYY" readonly required>
                </div>
                <div class="col-md-12 col-lg-6" id="remarkBox">
                    <div class="form-group my-3">
                        <label class="f-14 text-dark-grey mb-12" for="remarkInput">Remark</label>
                        <textarea id="remarkInput" class="form-control height-35 f-14 bg-white"
                            placeholder="Enter your remarks here..." rows="1" oninput="autoResize(this)"></textarea>
                    </div>
                </div>
                <div id="employee-details" style="display:none;">
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group my-3">
                            <label class="f-14 text-dark-grey mb-12">Branch <sup class="f-14 mr-1">*</sup></label>
                            <input type="text" class="form-control height-35 f-14" placeholder="Branch" name="branch"
                                id="branch" required>
                            @error('branch')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group my-3">
                            <label class="f-14 text-dark-grey mb-12">Branch <sup class="f-14 mr-1">*</sup></label>
                            <input type="text" class="form-control height-35 f-14" placeholder="Branch" name="branch"
                                id="branch" required>
                            @error('branch')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group my-3">
                            <label class="f-14 text-dark-grey mb-12">Branch <sup class="f-14 mr-1">*</sup></label>
                            <input type="text" class="form-control height-35 f-14" placeholder="Branch" name="branch"
                                id="branch" required>
                            @error('branch')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <script>
                        $(document).ready(function () {
                            $('#employee').on('change', function () {
                                var employeeId = $(this).val(); // Get selected employee ID

                                if (employeeId) {
                                    $.ajax({
                                        url: '{{ route("getEmployeeIndicatorData") }}', // Route to fetch employee details and indicator data
                                        type: 'GET',
                                        data: { id: employeeId },
                                        success: function (response) {
                                            if (response.error) {
                                                alert(response.error);
                                                return;
                                            }

                                            // Display employee details and indicators below
                                            $('#employee-details').html(`
                            <div class="card p-3 mt-3">
                                <h5>Employee Details</h5>
                                <p><strong>Name:</strong> ${response.name}</p>
                                <p><strong>Email:</strong> ${response.email}</p>
                                <p><strong>Role:</strong> ${response.role}</p>

                                <h6>Indicator Data:</h6>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Indicator Name</th>
                                            <th>Value</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ${response.indicators.map(indicator => `
                                            <tr>
                                                <td>${indicator.name}</td>
                                                <td>${indicator.value}</td>
                                            </tr>
                                        `).join('')}
                                    </tbody>
                                </table>
                            </div>
                        `);
                                            $('#employee-details').show();
                                        },
                                        error: function (error) {
                                            console.error('Error fetching data:', error);
                                        }
                                    });
                                } else {
                                    $('#employee-details').hide();
                                }
                            });
                        });
                    </script>
                </div>
                <button type="submit" class="btn-primary rounded f-14 p-2 mr-3">
                    <i class="fa fa-check mr-1"></i>Save
                </button>
                <a href="{{ route('appraisal.index') }}" class="btn-cancel rounded f-14 p-2">Cancel</a>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        $(document).ready(function () {
            flatpickr("#monthYearPicker", {
                enableTime: false,
                dateFormat: "m/Y",
                minDate: "today",
                mode: "single",
                monthSelectorType: "static",
                onChange: function (selectedDates) {
                    let date = selectedDates[0];
                    let month = ("0" + (date.getMonth() + 1)).slice(-2);
                    let year = date.getFullYear();
                    let formattedDate = `${month}/${year}`;
                    document.getElementById("monthYearPicker").value = formattedDate;
                }
            });
        });

        function autoResize(textarea) {
            textarea.style.height = "auto";
            textarea.style.height = textarea.scrollHeight + "px";
        }
    </script>
@endpush

@push('styles')
    <style>
        #remarkInput {
            border: 1px solid #ced4da;
            border-radius: 5px;
            padding: 10px;
            color: #000;
            font-size: 14px;
            overflow: hidden;
            resize: none;
            line-height: 1.5;
            transition: height 0.2s ease;
        }

        #remarkInput::placeholder,
        #monthYearPicker::placeholder {
            color: #abb5c2;
        }

        #remarkInput:focus {
            border-color: #5b9bd5;
            box-shadow: 0 0 5px rgba(91, 155, 213, 0.5);
            outline: none;
        }
    </style>
@endpush
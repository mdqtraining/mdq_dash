@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('vendor/full-calendar/main.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/css/bootstrap-colorpicker.css') }}" />
@endpush

@push('datatable-styles')
@include('sections.daterange_css')
@endpush

@section('content')
<div class="content-wrapper">
    <div class="add-page">
        <div class="p-20">
            <h4 class="mb-0 p-20 f-21 font-weight-normal text-capitalize border-bottom-grey">
                @lang('app.menu.indicatorDetials')</h4>
            <div class="row p-20">
                <div class="col-lg-4 col-md-6">
                    <x-forms.text :fieldLabel="__('Branch')" fieldName="branch_name"
                        fieldId="branch_name" :fieldPlaceholder="__('branch')" fieldRequired="true" />
                </div>
                <div class="col-lg-4 col-md-6">
                    <x-forms.text :fieldLabel="__('Department')" fieldName="department_name"
                        fieldId="department_name" :fieldPlaceholder="__('department')" fieldRequired="true" />
                </div>
                <div class="col-lg-4 col-md-6">
                    <x-forms.text :fieldLabel="__('Designation')" fieldName="designation_name"
                        fieldId="designation_name" :fieldPlaceholder="__('Designation')" fieldRequired="true" />
                </div>
            </div>
            <div class="col-md-6 col-lg-4" id="deadlineBox">
                <label for="monthYearPicker" class="f-14 text-dark-grey mb-12">Select Month and Year <sup class="f-14 mr-1">*</sup></label>
                <input type="text" id="monthYearPicker" class="form-control height-35 f-14 bg-white" placeholder="MM/YYYY" readonly>
            </div>
            <div class="col-md-12 col-lg-6" id="deadlineBox">
                <div class="form-group my-3">
                    <x-forms.label class="my-3" fieldId="notes"
                        :fieldLabel="__('Remark')">
                    </x-forms.label>
                    <textarea
                        id="remarkInput"
                        class="form-control height-35 f-14 bg-white"
                        placeholder="Enter your remarks here..."
                        rows="1"
                        oninput="autoResize(this)"></textarea>
                </div>
            </div>



        </div>
        <x-form-actions>
            <x-forms.button-primary id="save-indicator-form" class="mr-3" icon="check">@lang('app.save')
            </x-forms.button-primary>
            <x-forms.button-cancel :link="route('indicator.index')" class="border-0">@lang('app.cancel')
            </x-forms.button-cancel>
        </x-form-actions>

        <!-- Include jQuery and jQuery UI -->
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">


        <script>
            $(document).ready(function() {
                $("#monthYearPicker").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    showButtonPanel: true,
                    dateFormat: "mm/yy",
                    onClose: function(dateText, inst) {
                        // Get selected month and year
                        var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                        var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                        $(this).val($.datepicker.formatDate('mm/yy', new Date(year, month, 1)));
                    },
                    beforeShow: function(input, inst) {
                        // Hide calendar grid
                        $(".ui-datepicker-calendar").hide();
                        if ((selectedDate = $(this).val()).length > 0) {
                            var month = selectedDate.split("/")[0] - 1;
                            var year = selectedDate.split("/")[1];
                            $(this).datepicker('option', 'defaultDate', new Date(year, month, 1));
                            $(this).datepicker('setDate', new Date(year, month, 1));
                        }
                    }
                });
            });
        </script>
    </div>
</div>
</div>
@endsection

<style>
    #remarkInput {
        border: 1px solid #ced4da;
        border-radius: 5px;
        padding: 10px;
        color: #000; /* Entered text color */
        font-size: 14px;
        overflow: hidden; /* Hide scrollbar */
        resize: none; /* Prevent manual resizing */
        line-height: 1.5; /* Adjust line height for better spacing */
        transition: height 0.2s ease; /* Smooth height adjustment */
    }

    /* Styling the placeholder */
    #remarkInput::placeholder {
        color: #abb5c2; 
    }

    /* Focused state styling */
    #remarkInput:focus {
        border-color: #5b9bd5; /* Blue border on focus */
        box-shadow: 0 0 5px rgba(91, 155, 213, 0.5); /* Subtle shadow effect */
        outline: none; /* Remove default outline */
    }
    .rating span {
        font-size: 24px;
        cursor: pointer;
        color: #ccc;
        /* Default star color */
        transition: color 0.3s;
    }

    #monthYearPicker::placeholder {
        color: #abb5c2;
        /* Placeholder color */
    }

    /* Ensure entered text is styled normally */
    #monthYearPicker {
        color: #000;
        /* Entered value color (black) */
    }

    .rating span.selected {
        color: #ffd700;
        /* Gold color when selected */
    }
</style>

<script>
    function autoResize(textarea) {
        // Reset height to calculate new height
        textarea.style.height = "auto";
        // Dynamically adjust the height based on content
        textarea.style.height = textarea.scrollHeight + "px";
    }
</script>
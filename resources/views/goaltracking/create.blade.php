@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('vendor/full-calendar/main.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/css/bootstrap-colorpicker.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@push('datatable-styles')
    @include('sections.daterange_css')
@endpush

@section('content')
<div class="content-wrapper">
    <form action="{{ route('goaltracking.store') }}" method="POST" id="goaltrackingForm">
        @csrf
        <div class="add-page">
            <div class="p-20">
                <h4 class="mb-0 p-20 f-21 font-weight-normal text-capitalize border-bottom-grey">
                    @lang('app.menu.indicatorDetials')
                </h4>
                <div class="row p-20">
                    <div class="col-md-12 col-lg-6">
                        <div class="form-group my-3">
                            <label class="f-14 text-dark-grey mb-12">Branch &nbsp;<sup class="f-14 mr-1">*</sup></label>
                            <select class="form-control height-35 f-14" name="branch" id="branch" required>
                                <option value="" disabled selected>Select Branch</option>
                                @foreach($branchname as $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6">
                        <div class="form-group my-3">
                            <label class="f-14 text-dark-grey mb-12">Goal Type &nbsp;<sup
                                    class="f-14 mr-1">*</sup></label>
                            <div class="input-group">
                                <select class="form-control height-35 f-14" name="goal_type" id="goal_type" required>
                                    <option value="" disabled selected>Select Goal Type</option>
                                    @foreach($goals as $item)
                                        <option value="{{ $item }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                                <div class="input-group-append">
                                    <button id="addClientCategory" type="button"
                                        class="btn btn-outline-secondary border-grey" data-toggle="tooltip"
                                        data-original-title="{{ __('app.add') . ' ' . __('modules.client.clientCategory') }}">
                                        @lang('app.add')</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6">
                        <div class="form-group my-3">
                            <label for="startDatePicker" class="f-14 text-dark-grey mb-12">Start Date <sup
                                    class="f-14 mr-1">*</sup></label>
                            <input type="text" id="startDatePicker" name="date"
                                class="form-control height-35 f-14 bg-white" placeholder="Select Date" required>
                        </div>
                    </div>

                    <div class="col-md-12 col-lg-6">
                        <div class="form-group my-3">
                            <label for="endDatePicker" class="f-14 text-dark-grey mb-12">End Date <sup
                                    class="f-14 mr-1">*</sup></label>
                            <input type="text" id="endDatePicker" name="date"
                                class="form-control height-35 f-14 bg-white" placeholder="Select Date" required>
                        </div>
                    </div>


                    <div class="col-md-12 col-lg-6">
                        <div class="form-group my-3">
                            <label for="endDatePicker" class="f-14 text-dark-grey mb-12">Subject<sup
                                    class="f-14 mr-1">*</sup></label>
                            <input type="text" class="form-control height-35 f-14" placeholder="Enter goal subject"
                                name="subject" id="subject" required>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6">
                        <div class="form-group my-3">
                            <label for="endDatePicker" class="f-14 text-dark-grey mb-12">Target Achievement<sup
                                    class="f-14 mr-1">*</sup></label>
                            <input type="text" class="form-control height-35 f-14"
                                placeholder="Enter target achievement" name="target" id="target" required>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6">
                        <div class="form-group my-3">
                            <label for="endDatePicker" class="f-14 text-dark-grey mb-12">Description</label>
                            <textarea id="description" name="description" class="form-control height-35 f-14 bg-white"
                                placeholder="Enter your Description here..." rows="1" oninput="autoResize(this)"
                                pattern="[A-Za-z0-9\s-]+"></textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn-primary rounded f-14 p-2 mr-3">
                        <i class="fa fa-check mr-1"></i>Save
                    </button>
                    <a href="{{route('goaltracking.index') }}" class="btn-cancel rounded f-14 p-2">cancel</a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
<!-- Include Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Restrict special characters in text inputs (Remark, Subject, Target, Description)
        function restrictTextInput(event) {
            const allowedKeys = ["Backspace", "Delete", "ArrowLeft", "ArrowRight", "Tab", "Enter"];
            if (!/^[A-Za-z0-9\s-]$/.test(event.key) && !allowedKeys.includes(event.key)) {
                event.preventDefault();
            }
        }
        function restrictNumberInput(event) {
            const allowedKeys = ["Backspace", "Delete", "ArrowLeft", "ArrowRight", "Tab"];
            if (!/^[0-9]$/.test(event.key) && !allowedKeys.includes(event.key)) {
                event.preventDefault();
            }
        }
        // Restrict date input to only numbers and hyphen (-)
        function restrictDateInput(event) {
            const allowedKeys = ["Backspace", "Delete", "ArrowLeft", "ArrowRight", "Tab"];
            if (!/^[0-9-]$/.test(event.key) && !allowedKeys.includes(event.key)) {
                event.preventDefault();
            }
        }

        // Get elements and attach restrictions
        let textFields = ["remarkInput", "subject", "description"];
        textFields.forEach(function (id) {
            let element = document.getElementById(id);
            if (element) {
                element.addEventListener("keydown", restrictTextInput); // Change to keydown
                element.addEventListener("input", function () {
                    this.value = this.value.replace(/[^A-Za-z0-9\s-]/g, ""); // Remove invalid chars dynamically
                });
            }
        });
        let targetField = document.getElementById("target");
        if (targetField) {
            targetField.addEventListener("keydown", restrictNumberInput);
            targetField.addEventListener("input", function () {
                this.value = this.value.replace(/[^0-9]/g, ""); // Allow only numbers (remove spaces)
            });
        }
        // Restrict manual input for date fields
        let dateFields = ["startDatePicker", "endDatePicker"];
        dateFields.forEach(function (id) {
            let element = document.getElementById(id);
            if (element) {
                element.addEventListener("keydown", restrictDateInput); // Change to keydown
                element.addEventListener("input", function () {
                    this.value = this.value.replace(/[^0-9-]/g, ""); // Remove invalid chars dynamically
                });
            }
        });

        flatpickr("#startDatePicker", {
            dateFormat: "d-m-Y",
            allowInput: true,
            disableMobile: true,
            onChange: function (selectedDates, dateStr, instance) {
                const startDate = selectedDates[0];
                const endDate = document.getElementById("endDatePicker").value;
                if (endDate) {
                    const end = flatpickr.parseDate(endDate, "d-m-Y");
                    if (end && startDate > end) {
                        alert("Start date must be before or on the end date.");
                        instance.setDate(endDate, true); // Reset start date
                    }
                }
            }
        });

        // Initialize Flatpickr for end date with validation
        flatpickr("#endDatePicker", {
            dateFormat: "d-m-Y",
            allowInput: true,
            disableMobile: true,
            onChange: function (selectedDates, dateStr, instance) {
                const endDate = selectedDates[0];
                const startDate = document.getElementById("startDatePicker").value;
                if (startDate) {
                    const start = flatpickr.parseDate(startDate, "d-m-Y");
                    if (endDate && endDate < start) {
                        alert("End date must be after or on the start date.");
                        instance.setDate(startDate, true); // Reset end date
                    }
                }
            }
        });
        // Auto resize textarea
        function autoResize(textarea) {
            textarea.style.height = "auto";
            textarea.style.height = textarea.scrollHeight + "px";
        }
        document.querySelector("#goaltrackingForm").addEventListener("submit", function (event) {
            let isValid = true;
            // Check required fields (including text, select, and rating inputs)
            document.querySelectorAll("input[required], select[required], input[type='hidden'][required]").forEach((field) => {
                if (!field.value.trim()) {
                    showValidationMessage(field, "This field is required");
                    isValid = false; 
                } else {
                    removeValidationMessage(field);
                }
            });

            if (!isValid) {
                event.preventDefault(); // Stop form submission
            }
        });
    });
</script>
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

    #remarkInput::placeholder {
        color: #abb5c2;
    }

    #remarkInput:focus {
        border-color: #5b9bd5;
        box-shadow: 0 0 5px rgba(91, 155, 213, 0.5);
        outline: none;
    }

    #newDatePicker::placeholder {
        color: #abb5c2;
    }

    #newDatePicker {
        color: #000;
    }
</style>
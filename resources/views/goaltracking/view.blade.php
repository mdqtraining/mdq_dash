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
    <div class="add-page">
        <div class="p-20">
            <h4 class="mb-0 p-20 f-21 font-weight-normal text-capitalize border-bottom-grey">
                Goal Tracking Detials
            </h4>
            <div class="row p-20">
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif
                <script>
                    setTimeout(() => {
                        document.querySelectorAll('.alert').forEach(alert => alert.remove());
                    }, 5000);
                </script>
                <div class="col-md-12 col-lg-6">
                    <div class="form-group my-3">
                        <label class="f-14 text-dark-grey mb-12">Branch &nbsp;<sup class="f-14 mr-1">*</sup></label>
                        <select class="form-control height-35 f-14" name="branch" id="branch" required readonly>
                            <option value="{{$goaltracking->branch}}" selected>{{ $goaltracking->branch }}</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-12 col-lg-6">
                    <div class="form-group my-3">
                        <label class="f-14 text-dark-grey mb-12">Goal Type &nbsp;<sup
                                class="f-14 mr-1">*</sup></label>
                        <select class="form-control height-35 f-14" name="goal_type" id="goal_type" required readonly>
                            <option value="{{ $goaltracking->goal_type }}" selected>{{ $goaltracking->goal_type }}</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-12 col-lg-6">
                    <div class="form-group my-3">
                        <label for="startDatePicker" class="f-14 text-dark-grey mb-12">Start Date <sup class="f-14 mr-1">*</sup></label>
                        <input type="text" id="startDatePicker" name="start_date" class="form-control height-35 f-14 bg-white" placeholder="Select Date" value="{{$goaltracking->start_date}}" required readonly>
                    </div>
                </div>

                <div class="col-md-12 col-lg-6">
                    <div class="form-group my-3">
                        <label for="endDatePicker" class="f-14 text-dark-grey mb-12">End Date <sup class="f-14 mr-1">*</sup></label>
                        <input type="text" id="endDatePicker" name="end_date" class="form-control height-35 f-14 bg-white" placeholder="Select Date" value="{{$goaltracking->end_date}}" required readonly>
                    </div>
                </div>
                <div class="col-md-12 col-lg-6">
                    <div class="form-group my-3">
                        <label for="endDatePicker" class="f-14 text-dark-grey mb-12">Subject<sup
                                class="f-14 mr-1">*</sup></label>
                        <input type="text" class="form-control height-35 f-14" placeholder="Enter goal subject"
                            name="subject" id="subject" value="{{$goaltracking->subject}}" required readonly>
                    </div>
                </div>
                <div class="col-md-12 col-lg-6">
                    <div class="form-group my-3">
                        <label for="endDatePicker" class="f-14 text-dark-grey mb-12">Target Achievement<sup
                                class="f-14 mr-1">*</sup></label>
                        <input type="text" class="form-control height-35 f-14"
                            placeholder="Enter target achievement" name="target" id="target" value="{{$goaltracking->target}}" required readonly>
                    </div>
                </div>
                <div class="col-md-12 col-lg-6">
                    <div class="form-group my-3">
                        <label for="description" class="f-14 text-dark-grey mb-12">Description</label>
                        <textarea id="description" name="description" class="form-control height-35 f-14"
                            placeholder="Enter your Description here..." readonly>{{$goaltracking->description}}
                        </textarea>
                    </div>
                </div>
                <div class="col-md-12 col-lg-6">
                    <div class="form-group my-3">
                    </div>
                </div>
                <div style="width: 100%;">
                    <div class="col-md-12 col-lg-6">
                        <div class="form-group my-3">
                            <label for="status" class="f-14 text-dark-grey mb-12">Status&nbsp;<sup class="f-14 mr-1">*</sup></label>
                            <select class="form-control height-35 f-14" name="status" id="status" readonly>
                                <option value="{{$goaltracking->status}}" selected>{{$goaltracking->status}}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div style="width: 100%; padding: 20px">
                    <div class="rating" id="starRating" data-rating="{{$goaltracking->rating}}">
                        <span data-value="1">&#9733;</span>
                        <span data-value="2">&#9733;</span>
                        <span data-value="3">&#9733;</span>
                        <span data-value="4">&#9733;</span>
                        <span data-value="5">&#9733;</span>
                    </div>

                    <input type="hidden" name="rating" id="rating" value="{{$goaltracking->rating}}" readonly>

                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            let ratingContainer = document.getElementById("starRating");
                            let stars = ratingContainer.querySelectorAll("span");
                            let ratingInput = document.getElementById("rating");
                            let currentRating = parseInt(ratingContainer.getAttribute("data-rating"));

                            // Function to fill stars up to a given value
                            function fillStars(value) {
                                stars.forEach(star => {
                                    star.classList.toggle("filled", star.dataset.value <= value);
                                });
                            }

                            // Initialize with existing rating
                            fillStars(currentRating);

                            // Hover effect
                            stars.forEach(star => {
                                star.addEventListener("mouseenter", function() {
                                    fillStars(this.dataset.value);
                                });

                                star.addEventListener("mouseleave", function() {
                                    fillStars(currentRating); // Reset to selected rating on mouse out
                                });
                            });
                        });
                    </script>
                </div>
                <div style="width: 100%; padding: 20px">
                    <div class="progress-container" id="progressContainer">
                        <div class="progress-bar" id="progressBar"></div>
                    </div>
                    <div class="progress-value" id="progressValue">{{$goaltracking->progress}}%</div>
                    <input type="hidden" name="progress" id="progress" value="{{$goaltracking->progress}}">
                </div>
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        let progressBar = document.getElementById("progressBar");
                        let progressValue = document.getElementById("progressValue");
                        let progressInput = document.getElementById("progress");

                        // Get initial progress from backend
                        let initialProgress = parseInt(progressInput.value) || 0;

                        // Set progress on page load
                        function setProgress(value) {
                            progressBar.style.width = value + "%";
                            progressValue.innerText = value + "%";
                        }

                        setProgress(initialProgress); // Initialize progress display

                        // Remove click event listener to prevent changes
                    });
                </script>
            </div>
            <a href="{{route('goaltracking.edit',$goaltracking->id) }}" class="rounded f-14 p-2 edit-a-btn" style="background-color:#6FD943; color:white ;">Edit</a>
            <a href="{{route('goaltracking.index') }}" class="btn-cancel rounded f-14 p-2">cancel</a>
        </div>
    </div>
</div>
@endsection
<!-- Include Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
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

        // Restrict manual input for date fields
        function restrictDateInput(event) {
            const allowedKeys = ["Backspace", "Delete", "ArrowLeft", "ArrowRight", "Tab"];
            if (!/^[0-9-]$/.test(event.key) && !allowedKeys.includes(event.key)) {
                event.preventDefault();
            }
        }

        // Get elements and attach restrictions
        let textFields = ["remarkInput", "subject", "description"];
        textFields.forEach(function(id) {
            let element = document.getElementById(id);
            if (element) {
                element.addEventListener("keydown", restrictTextInput); // Change to keydown
                element.addEventListener("input", function() {
                    this.value = this.value.replace(/[^A-Za-z0-9\s-]/g, ""); // Remove invalid chars dynamically
                });
            }
        });

        let targetField = document.getElementById("target");
        if (targetField) {
            targetField.addEventListener("keydown", restrictNumberInput);
            targetField.addEventListener("input", function() {
                this.value = this.value.replace(/[^0-9]/g, ""); // Allow only numbers (remove spaces)
            });
        }

        // Restrict manual input for date fields
        let dateFields = ["startDatePicker", "endDatePicker"];
        dateFields.forEach(function(id) {
            let element = document.getElementById(id);
            if (element) {
                element.addEventListener("keydown", restrictDateInput); // Change to keydown
                element.addEventListener("input", function() {
                    this.value = this.value.replace(/[^0-9-]/g, ""); // Remove invalid chars dynamically
                });
            }
        });

        // Initialize Flatpickr for start date
        let startDatePicker = flatpickr("#startDatePicker", {
            dateFormat: "Y-m-d",
            allowInput: true,
            disableMobile: true,
            onChange: function(selectedDates, dateStr, instance) {
                // Update end date's minDate whenever start date changes
                endDatePicker.set('minDate', dateStr);
            }
        });

        // Initialize Flatpickr for end date
        let endDatePicker = flatpickr("#endDatePicker", {
            dateFormat: "Y-m-d",
            allowInput: true,
            disableMobile: true,
            onChange: function(selectedDates, dateStr, instance) {
                // Update start date's maxDate whenever end date changes
                startDatePicker.set('maxDate', dateStr);
            }
        });

        // Auto resize textarea
        function autoResize(textarea) {
            textarea.style.height = "auto";
            textarea.style.height = textarea.scrollHeight + "px";
        }

        document.querySelector("#goaltrackingForm").addEventListener("submit", function(event) {
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

            console.log("Form validation status: " + isValid); // Log validation status

            if (!isValid) {
                event.preventDefault(); // Stop form submission
                console.log("Form is invalid, submission prevented"); // Log when submission is prevented
            } else {
                console.log("Form is valid, submitting..."); // Log successful validation
            }
        });
    });
</script>

<style>
    .rating {
        font-size: 30px;
        cursor: pointer;
        display: inline-block;
    }

    .rating span {
        color: #ccc;
        /* Default empty star color */
        transition: color 0.2s;
    }

    .rating span.filled {
        color: gold;
        /* Filled star color */
    }

    .progress-container {
        width: 100%;
        background-color: #ddd;
        border-radius: 10px;
        overflow: hidden;
        height: 10px;
        margin: 20px auto;
        cursor: pointer;
    }

    .progress-bar {
        height: 100%;
        width: 0%;
        transition: width 0.2s ease-in-out;
    }


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
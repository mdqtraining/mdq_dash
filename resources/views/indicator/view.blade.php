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
                    @lang('app.menu.indicatorDetials')
                </h4>
                <div class="row p-20">
                    <!-- Branch Field -->
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group my-3">
                            <label class="f-14 text-dark-grey mb-12">Branch &nbsp;<sup class="f-14 mr-1">*</sup></label>
                            <input type="text" class="form-control height-35 f-14" placeholder="Branch" name="branch"
                                id="branch" value={{$indicators->branch}} readonly>
                               
                        </div>
                    </div>

                    <!-- Department Field -->
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group my-3">
                            <label class="f-14 text-dark-grey mb-12">Department &nbsp;<sup
                                    class="f-14 mr-1">*</sup></label>
                            <input type="text" class="form-control height-35 f-14" placeholder="Department"
                                name="department" id="department" value={{$indicators->department}} readonly>
                        </div>
                    </div>

                    <!-- Designation Field -->
                    <div class="col-lg-4 col-md-6">
    <div class="form-group my-3">
        <label class="f-14 text-dark-grey mb-12">Designation &nbsp;<sup class="f-14 mr-1">*</sup></label>
        
        <select class="form-control height-35 f-14" name="designation" id="designation" disabled>
    <option value="{{ $indicators->designation }}" selected>{{ $indicators->designation }}</option>
</select>

    </div>
</div>

                </div>

                <h4 class="mb-0 p-20 f-15 font-weight-normal text-capitalize border-bottom-grey">Organizational
                    Competencies</h4>
                <div class="p-20">
                    <!-- Leadership Field -->
                    <div class="d-flex p-20 align-items-center">
                        <div class="col-6 text-dark-grey">Leadership</div>
                        <div class="f-21 col-6">
                            <div class="rating" data-rating={{$indicators->leadership}}>
                                <span data-value="1">&#9733;</span>
                                <span data-value="2">&#9733;</span>
                                <span data-value="3">&#9733;</span>
                                <span data-value="4">&#9733;</span>
                                <span data-value="5">&#9733;</span>
                            </div>
                            <input type="hidden" name="leadership" id="leadership" required>
                            
                        </div>
                    </div>

                    <!-- Project Management Field -->
                    <div class="d-flex p-20 align-items-center">
                        <div class="col-6 text-dark-grey">Project Management</div>
                        <div class="f-21 col-6">
                            <div class="rating" data-rating={{$indicators->project_management}}>
                                <span data-value="1">&#9733;</span>
                                <span data-value="2">&#9733;</span>
                                <span data-value="3">&#9733;</span>
                                <span data-value="4">&#9733;</span>
                                <span data-value="5">&#9733;</span>
                            </div>
                            <input type="hidden" name="project_management" id="project_management" required>
                           
                        </div>
                    </div>
                </div>

                <h4 class="mb-0 p-20 f-15 font-weight-normal text-capitalize border-bottom-grey">Technical Competencies
                </h4>
                <div class="p-20">
                    <!-- Allocating Resources Field -->
                    <div class="d-flex p-20 align-items-center">
                        <div class="col-6 text-dark-grey">Allocating Resources</div>
                        <div class="f-21 col-6">
                            <div class="rating" data-rating={{$indicators->allocating_resources}}>
                                <span data-value="1">&#9733;</span>
                                <span data-value="2">&#9733;</span>
                                <span data-value="3">&#9733;</span>
                                <span data-value="4">&#9733;</span>
                                <span data-value="5">&#9733;</span>
                            </div>
                            <input type="hidden" name="allocating_resources" id="allocating_resources" required>
                        </div>
                    </div>
                </div>

                <h4 class="mb-0 p-20 f-15 font-weight-normal text-capitalize border-bottom-grey">Behavioural
                    Competencies</h4>
                <div class="p-20">
                    <!-- Business Process Field -->
                    <div class="d-flex p-20 align-items-center">
                        <div class="col-6 text-dark-grey">Business Process</div>
                        <div class="f-21 col-6">
                            <div class="rating" data-rating={{$indicators->business_process}}>
                                <span data-value="1">&#9733;</span>
                                <span data-value="2">&#9733;</span>
                                <span data-value="3">&#9733;</span>
                                <span data-value="4">&#9733;</span>
                                <span data-value="5">&#9733;</span>
                            </div>
                            <input type="hidden" name="business_process" id="business_process" required>
                           
                        </div>
                    </div>

                    <!-- Oral Communication Field -->
                    <div class="d-flex p-20 align-items-center">
                        <div class="col-6 text-dark-grey">Oral Communication</div>
                        <div class="f-21 col-6">
                            <div class="rating" data-rating={{$indicators->oralcommunication}}>
                                <span data-value="1">&#9733;</span>
                                <span data-value="2">&#9733;</span>
                                <span data-value="3">&#9733;</span>
                                <span data-value="4">&#9733;</span>
                                <span data-value="5">&#9733;</span>
                            </div>
                            <input type="hidden" name="oralcommunication" id="oralcommunication" required>
                        </div>
                    </div>
                </div>
                <a href="{{route('indicator.edit',$indicators) }}" class="btn-primary rounded f-14 p-2 mr-3"><i class="fa fa-edit mr-1"></i>edit</a>
                <a href="{{route('indicator.index') }}" class="btn-cancel rounded f-14 p-2">cancel</a>
            </div>
        </div>
    </div>


@endsection

<!-- Custom Styles and Scripts -->
<style>
    .error-message {
        background-color: #ff3a6e;
        color: white;
        padding: 10px;
        border-radius: 5px;
        position: relative;
        margin-top: 10px;
        max-width: 50%;
        transform: translateX(100%);
        animation: slideIn 0.5s forwards, disappear .5s 3.5s forwards;
    }

    @keyframes slideIn {
        to {
            transform: translateX(0);
        }
    }

    @keyframes disappear {
        to {
            opacity: 0;
            transform: translateX(100%);
        }
    }

    .rating span {
        font-size: 24px;
        cursor: pointer;
        color: #ccc;
        transition: color 0.3s;
    }

    .rating {
        cursor: pointer;
    }

    .rating span.selected {
        color: #ffd700;
    }
</style>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Prevent special characters in text fields
        document.querySelectorAll("input[type='text']").forEach((input) => {
            input.addEventListener("keypress", function (e) {
                let regex = /^[a-zA-Z0-9\s]$/; // Allow only letters, numbers, and spaces
                let key = String.fromCharCode(e.keyCode || e.which);

                if (!regex.test(key)) {
                    e.preventDefault(); // Block the key press
                }
            });
        });

        // Star rating functionality (only for display)
        const ratingContainers = document.querySelectorAll(".rating");

        ratingContainers.forEach((ratingContainer) => {
            const stars = ratingContainer.querySelectorAll("span");
            const currentRating = ratingContainer.getAttribute("data-rating") || 0;

            // Function to highlight stars based on rating value
            function updateStars(value) {
                stars.forEach((s) => {
                    s.classList.toggle("selected", s.getAttribute("data-value") <= value);
                });
            }

            // Initialize stars on page load based on data-rating
            updateStars(currentRating);

            // Ensure the stars are visually filled based on data-rating without any interactivity
            ratingContainer.setAttribute("data-rating", currentRating);
        });

        // 💡 Live validation for required fields
        function showValidationMessage(field, message) {
            let errorDiv = field.nextElementSibling; // Find the existing error div
            if (!errorDiv || !errorDiv.classList.contains("error-message")) {
                errorDiv = document.createElement("div");
                errorDiv.classList.add("error-message");
                field.parentNode.appendChild(errorDiv);
            }
            errorDiv.textContent = message;
            errorDiv.style.opacity = "1";
            errorDiv.style.transform = "translateX(0)";
        }

        function removeValidationMessage(field) {
            let errorDiv = field.nextElementSibling;
            if (errorDiv && errorDiv.classList.contains("error-message")) {
                errorDiv.style.opacity = "0";
                setTimeout(() => errorDiv.remove(), 500);
            }
        }

        document.querySelector("#indicatorForm").addEventListener("submit", function (event) {
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

<header><meta name="csrf-token" content="{{ csrf_token() }}"></header>
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
                            <select class="form-control height-35 f-14" name="branch" id="branch" required>
                                <option value="" disabled selected>Select Branch</option>
                                @foreach($branchname as $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            </select>
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
                @foreach ($indicatorheaders as $category => $fields)
                    <h4 class="mb-0 p-20 f-15 font-weight-normal text-capitalize border-bottom-grey">{{ $category }}</h4>
                    <div class="p-20">
                        @foreach ($fields as $field)
                            <div class="d-flex p-20 align-items-center">
                                <div class="col-lg-4 col-md-6 text-dark-grey" >{{ $field->field_name }}</div>

                                <div class="f-21 col-6">
                                <div class="d-flex" style="justify-content: space-between;">
                                  <div class="rating rating-field" id="{{ $field->field_name }}" data-rating="0">
                                        <span data-value="1">&#9733;</span>
                                        <span data-value="2">&#9733;</span>
                                        <span data-value="3">&#9733;</span>
                                        <span data-value="4">&#9733;</span>
                                        <span data-value="5">&#9733;</span>
                                    </div>
                                    <div class="rating_appraisal"  data-rating="0">
                                        <span data-value="1">&#9733;</span>
                                        <span data-value="2">&#9733;</span>
                                        <span data-value="3">&#9733;</span>
                                        <span data-value="4">&#9733;</span>
                                        <span data-value="5">&#9733;</span>
                                    </div>
                                    <!-- <input type="hidden" name="ratings[{{ Str::slug($field->field_name, '_') }}]" required> -->
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
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
    var designation = "{{ route('getDesignation') }}";
</script>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
    let branchElement = document.getElementById("branch");
    let employeeElement = document.getElementById("employee");

    async function getDesignation() {
    try {
        if (typeof designation !== "string" || !designation.trim()) {
            console.error("Error: 'designation' variable is not defined or is not a valid URL.");
            return;
        }

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
        if (!csrfToken) {
            console.error("Error: CSRF token not found.");
            return;
        }

        const branchValue = branchElement?.value?.trim() || "";
        const employeeValue = employeeElement?.value?.trim() || "";

        if (!branchValue || !employeeValue) {
            console.warn("Warning: Branch or Employee is missing. Skipping API call.");
            return;
        }

        const response = await fetch(designation, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ branch: branchValue, employee: employeeValue })
        });

        if (!response.ok) {
            const errorText = await response.text();
            throw new Error(`HTTP error! Status: ${response.status}. Server response: ${errorText}`);
        }

        const data = await response.json();

        if (!data.designation || !Array.isArray(data.designation) || data.designation.length === 0) {
            console.warn("No valid designation data found in response.");
            return;
        }

        const designationData = data.designation[0];

        if (designationData.field_ratings) {
            try {
                const fieldRatings = JSON.parse(designationData.field_ratings);

                console.log("Field Ratings:", fieldRatings);

                // Loop through all elements and assign data-rating
                document.querySelectorAll(".rating-field").forEach(field => {
                    let fieldName = field.id; // Get field name from ID

                    if (fieldRatings.hasOwnProperty(fieldName)) {
                        field.setAttribute("data-rating", fieldRatings[fieldName]);
                    } else {
                        console.warn(`No rating found for ${fieldName}`);
                    }
                });

            } catch (parseError) {
                console.error("Error parsing field_ratings JSON:", parseError);
            }
        } else {
            console.warn("No field_ratings data available.");
        }

    } catch (error) {
        console.error("Error fetching designation:", error);
    }
}


    function fetchDesignations() {
        if (branchElement?.value && employeeElement?.value) {
            getDesignation();
        } else {
            console.error("Branch or Employee is missing or empty.");
        }
    }

    if (branchElement && employeeElement) {
        branchElement.addEventListener("change", fetchDesignations);
        employeeElement.addEventListener("change", fetchDesignations);
    } else {
        console.error("Branch or Employee element not found.");
    }
    if (typeof fieldRatings !== "undefined") {
        document.querySelectorAll(".rating").forEach((element) => {
            const fieldName = element.getAttribute("data-field");

            if (fieldRatings[fieldName] !== undefined) {
                const ratingValue = fieldRatings[fieldName]; // Get rating from JSON
                element.setAttribute("data-rating", ratingValue);

                // Highlight the correct number of stars
                highlightStars(element, ratingValue);
            }
        });
    }
});
 
    </script>
<script>document.addEventListener("DOMContentLoaded", function () {
    function setupRatings(selector, interactive) {
        document.querySelectorAll(selector).forEach((ratingContainer) => {
            const stars = ratingContainer.querySelectorAll("span");
            const hiddenInput = ratingContainer.nextElementSibling; // Get the next input field

            function updateStars(value) {
                stars.forEach((s) => {
                    s.classList.toggle("selected", s.getAttribute("data-value") <= value);
                });
            }

            // Set initial state
            const currentRating = ratingContainer.getAttribute("data-rating") || 0;
            updateStars(currentRating);
            if (hiddenInput) hiddenInput.value = currentRating;

            if (interactive) {
                stars.forEach((star) => {
                    star.addEventListener("click", function () {
                        const value = this.getAttribute("data-value");
                        ratingContainer.setAttribute("data-rating", value);
                        if (hiddenInput) hiddenInput.value = value;
                        updateStars(value);
                    });

                    star.addEventListener("mouseover", function () {
                        updateStars(this.getAttribute("data-value"));
                    });

                    star.addEventListener("mouseout", function () {
                        updateStars(ratingContainer.getAttribute("data-rating"));
                    });
                });
            }
        });
    }

    // Apply static ratings (read-only display)
    setupRatings(".rating", false);

    // Apply interactive ratings (clickable & hover effects)
    setupRatings(".rating_appraisal", true);
});
</script>

@endpush

@push('styles')
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

    .rating span ,.rating_appraisal span {
        font-size: 24px;
        cursor: pointer;
        color: #ccc;
        transition: color 0.3s;
    }

    .rating,.rating_appraisal {
        cursor: pointer;
    }

    .rating span.selected ,.rating_appraisal span.selected {
        color: #ffd700;
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
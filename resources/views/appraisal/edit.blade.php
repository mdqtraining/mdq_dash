<header>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</header>
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
<form action="{{ route('appraisal.update', $appraisal->id) }}" method="POST" id="appraisalForm">
    @csrf
    <div class="content-wrapper">
        <div class="add-page">

            @if (session('success'))
            <div class="alert alert-success mt-4">
                {{ session('success') }}
            </div>
            @endif

            @if (session('error'))
            <div class="alert alert-danger mt-4 ">
                {{ session('error') }}
            </div>
            @endif

            <script>
                setTimeout(() => {
                    document.querySelectorAll('.alert').forEach(alert => alert.remove());
                }, 5000); // Message disappears after 5 seconds
            </script>

            <h4 class="mb-0 p-20 f-21 font-weight-normal text-capitalize border-bottom-grey">
                Appraisal Detials
            </h4>

            <div class="row p-20">
                <div class="col-lg-4 col-md-6">
                    <div class="form-group my-3">
                        <label class="f-14 text-dark-grey mb-12">Branch <sup class="f-14 mr-1">*</sup></label>
                        <select class="form-control height-35 f-14" name="branch" id="branch" readonly>
                            <option value="{{$appraisal->branch}}" selected>
                                {{ $appraisal->branch }}
                            </option>
                        </select>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="form-group my-3">
                        <label class="f-14 text-dark-grey mb-12">Department <sup class="f-14 mr-1">*</sup></label>
                        <select class="form-control height-35 f-14" name="department" id="department" readonly>
                            <option value="{{ $appraisal->department }}" selected>
                                {{$appraisal->department}}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="form-group my-3">
                        <label class="f-14 text-dark-grey mb-12">Employee <sup class="f-14 mr-1">*</sup></label>
                        <select class="form-control height-35 f-14" name="employee" id="employee" readonly>
                            <option value="{{ $appraisal->employee_name }}">
                                {{ $appraisal->employee_name }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4" id="deadlineBox">
                <label for="monthYearPicker" class="f-14 text-dark-grey mb-12">Select Month and Year <sup class="f-14 mr-1">*</sup></label>
                <input type="text" id="monthYearPicker" name="month_year" class="form-control height-35 f-14 bg-white"
                    placeholder="MM/YYYY" value="{{$appraisal->appraisal_date}}" required maxlength="7">
                 <script>
                    document.getElementById('monthYearPicker').addEventListener('input', function(e) {
                        let value = e.target.value;

                        // Allow only numbers and "/"
                        value = value.replace(/[^0-9\/]/g, '');

                        // Auto-add "/" after two digits
                        if (value.length > 2 && value.charAt(2) !== '/') {
                            value = value.slice(0, 2) + '/' + value.slice(2);
                        }

                        // Limit length to 7 characters (MM/YYYY)
                        if (value.length > 7) {
                            value = value.slice(0, 7);
                        }

                        e.target.value = value;
                    });

                    document.getElementById('monthYearPicker').addEventListener('blur', function(e) {
                        let value = e.target.value.trim(); // Trim spaces
                        let errorMessage = document.getElementById('error-message');

                        // Regular expression to validate MM/YYYY format
                        let regex = /^(0[1-9]|1[0-2])\/\d{4}$/;

                        if (!regex.test(value)) {
                            errorMessage.style.display = 'inline'; // Show error message
                        } else {
                            errorMessage.style.display = 'none'; // Hide error message
                        }
                    });
                </script>
            </div>
            <div class="col-md-12 col-lg-6" id="remarkBox">
                <div class="form-group my-3">
                    <label class="f-14 text-dark-grey mb-12" for="remarkInput">Remark</label>
                    <textarea id="remarkInput" name="remark" class="form-control height-35 f-14 bg-white"
                        placeholder="Enter your remarks here..." rows="1" oninput="autoResize(this)" required> {{$appraisal->remark}}</textarea>
                </div>
            </div>
            <div>
                @php
                $indicator = $indicator->first();

                if ($indicator) {
                $field_ratings = json_decode($indicator->field_ratings, true);
                } else {
                $field_ratings = [];
                }
                $field_ratingsappraisal = json_decode($appraisal->field_ratings, true);
                @endphp
                @foreach ($indicatorheaders as $category => $fields)
                <h4 class="mb-0 p-20 f-15 font-weight-normal text-capitalize border-bottom-grey">{{ $category }}</h4>
                <div class="p-20">
                    @foreach ($fields as $field)
                    <div class="d-flex p-20 align-items-center">
                        <div class="col-lg-4 col-md-6 text-dark-grey">{{ $field->field_name }}</div>
                        @php
                        $normalized_field_name = Str::slug(strtolower(trim($field->field_name)), '_');
                        $appraisal_rating = $field_ratingsappraisal[$normalized_field_name] ?? 0;
                        $rating = $field_ratings[$field->field_name] ?? 0;
                        @endphp
                        <div class="f-21 col-6">
                            <div class="d-flex" style="justify-content: space-between;">
                                <div class="rating" id="{{ $field->field_name }}" data-rating="{{ $rating }}">
                                    <span data-value="1">&#9733;</span>
                                    <span data-value="2">&#9733;</span>
                                    <span data-value="3">&#9733;</span>
                                    <span data-value="4">&#9733;</span>
                                    <span data-value="5">&#9733;</span>
                                </div>
                                <div class="rating_appraisal" data-rating="{{ $appraisal_rating }}">
                                    <span data-value="1">&#9733;</span>
                                    <span data-value="2">&#9733;</span>
                                    <span data-value="3">&#9733;</span>
                                    <span data-value="4">&#9733;</span>
                                    <span data-value="5">&#9733;</span>
                                </div>
                                <input type="hidden" name="ratings[{{ Str::slug($field->field_name, '_') }}]" value="{{$appraisal_rating}}">
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endforeach
            </div>
            <div class="p-20">
                <button type="submit" class="btn-primary rounded f-14 p-2 mr-3">
                    <i class="fa fa-check mr-1"></i> Save
                </button>
                <a href="{{ route('appraisal.index') }}" class="btn-cancel rounded f-14 p-2 border-0">Cancel</a>
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
    document.addEventListener("DOMContentLoaded", function() {
        function setupRatings(selector, interactive) {
            document.querySelectorAll(selector).forEach((ratingContainer) => {
                const stars = ratingContainer.querySelectorAll("span");
                const hiddenInput = ratingContainer.nextElementSibling; // Hidden input to store value

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
                        star.addEventListener("click", function() {
                            const value = this.getAttribute("data-value");
                            ratingContainer.setAttribute("data-rating", value);
                            if (hiddenInput) hiddenInput.value = value;
                            updateStars(value);
                        });

                        star.addEventListener("mouseover", function() {
                            updateStars(this.getAttribute("data-value"));
                        });

                        star.addEventListener("mouseout", function() {
                            updateStars(ratingContainer.getAttribute("data-rating")); // Restore original rating
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
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/index.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/style.css">\
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const remarkInput = document.getElementById("remarkInput");
        if (remarkInput) {
            remarkInput.addEventListener("keydown", function(event) {
                const allowedKeys = ["Backspace", "Delete", "ArrowLeft", "ArrowRight", "Tab", "SpaceBar"];

                // Allow letters (a-z, A-Z), numbers (0-9), space, and essential keys
                if (!event.key.match(/^[a-zA-Z0-9\s]$/) && !allowedKeys.includes(event.key)) {
                    event.preventDefault(); // Block disallowed keys
                }
            });
        }
        flatpickr("#monthYearPicker", {
            dateFormat: "m/Y",
            allowInput: true,
            disableMobile: true,
            plugins: [new monthSelectPlugin({
                shorthand: true,
                dateFormat: "m/Y",
                theme: "light"
            })],
            onChange: function(selectedDates, dateStr, instance) {
                console.log("Selected Month & Year:", dateStr);
            }
        });
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

    .rating span,
    .rating_appraisal span {
        font-size: 24px;
        cursor: pointer;
        color: #ccc;
        transition: color 0.3s;
    }

    .rating,
    .rating_appraisal {
        cursor: pointer;
    }

    .rating span.selected,
    .rating_appraisal span.selected {
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
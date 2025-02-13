@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('vendor/full-calendar/main.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/css/bootstrap-colorpicker.css') }}" />
@endpush

@push('datatable-styles')
@include('sections.daterange_css')
@endpush

@section('content')
<form action="{{ route('indicator.update', $indicators->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="content-wrapper">
        <div class="add-page">
            <div class="p-20">
                @if (session('success'))
                <div class="alert alert-success mt-4">
                    {{ session('success') }}
                </div>
                @endif

                @if (session('error'))
                <div class="alert alert-danger mt-4">
                    {{ session('error') }}
                </div>
                @endif
                <script>
                    setTimeout(() => {
                        document.querySelectorAll('.alert').forEach(alert => alert.remove());
                    }, 5000); // Message disappears after 3 seconds
                </script>
                <h4 class="mb-0 p-20 f-21 font-weight-normal text-capitalize border-bottom-grey">
                    @lang('app.menu.indicatorDetials')
                </h4>
                <div class="row p-20">
                    <!-- Branch Field -->
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group my-3">
                            <label class="f-14 text-dark-grey mb-12">Branch &nbsp;<sup class="f-14 mr-1">*</sup></label>
                            <select class="form-control height-35 f-14" name="branch" id="branch" required>
                                @foreach($branchname as $item)
                                <option value="{{ $item }}"
                                    {{ $indicators->branch == $item ? 'selected' : '' }}>
                                    {{ $item }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- Department Field -->
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group my-3">
                            <label class="f-14 text-dark-grey mb-12">Department &nbsp;<sup
                                    class="f-14 mr-1">*</sup></label>
                            <select class="form-control height-35 f-14" name="department" id="department" required>
                                @foreach($departments as $item)
                                <option value="{{ $item }}"
                                    {{ isset($indicators) && $indicators->department == $item ? 'selected' : '' }}>
                                    {{ $item }}
                                </option>
                                @endforeach
                            </select>

                            @error('department')
                            <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Designation Field -->
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group my-3">
                            <label class="f-14 text-dark-grey mb-12">Designation &nbsp;<sup class="f-14 mr-1">*</sup></label>
                            <select class="form-control height-35 f-14" name="designation" id="designation" required>
                                @foreach($designations as $item)
                                <option value="{{ $item }}"
                                    {{ $indicators->designation == $item ? 'selected' : '' }}>
                                    {{ $item }}
                                </option>
                                @endforeach
                            </select>
                            @error('designation')
                            <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                @php
                $field_ratings = json_decode($indicators->field_ratings, true);
                @endphp

                @foreach ($indicatorheaders as $category => $fields)
                <div class="d-flex justify-content-between align-items-center border-bottom-grey p-20">
                    <h4 class="mb-0 f-15 font-weight-normal text-capitalize">{{ $category }}</h4>
                    @if ($loop->first)
                    <!-- Button to trigger modal (Only in the first loop iteration) -->
                    <button type="button" class="btn btn-outline-secondary border-grey" data-bs-toggle="modal" data-bs-target="#addEventModal">
                        Add
                    </button>
                    @endif
                </div>
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        const addEventButton = document.getElementById("openEventModal");
                        const addEventModal = new bootstrap.Modal(document.getElementById("addEventModal"));

                        if (addEventButton) {
                            addEventButton.addEventListener("click", function() {
                                addEventModal.show();
                            });
                        }
                    });
                </script>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
                <!-- Modal -->
                <div class="p-20">
                    @foreach ($fields as $field)
                    <div class="d-flex p-20 align-items-center">
                        <div class="col-6 text-dark-grey">{{ $field->field_name }}</div>
                        @php
                        $rating = $field_ratings[$field->field_name] ?? 0;
                        @endphp
                        <div class="f-21 col-6">
                            <div class="rating" data-rating="{{ $rating }}">
                                <span data-value="1">&#9733;</span>
                                <span data-value="2">&#9733;</span>
                                <span data-value="3">&#9733;</span>
                                <span data-value="4">&#9733;</span>
                                <span data-value="5">&#9733;</span>
                            </div>
                            <input type="hidden" name="ratings[{{ Str::slug($field->field_name, '_') }}]" value="{{ $rating }}" required>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endforeach

                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</form>
<div class="modal fade" id="addEventModal" tabindex="-1" aria-labelledby="addEventModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm"> <!-- ⬅ Makes modal smaller -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEventModalLabel">Add New Rating Field</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-circle bg-white text-danger" style="font-size: 1.5rem"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="ratingFieldForm" action="{{ route('ratingfield.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="field_names" class="form-label">field Name</label>
                        <input type="text" class="form-control" id="field_names" name="field_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <select class="form-control" id="category" name="category" required>
                            <option value="" disabled selected>Select Category</option>
                            @foreach ($indicatorheaders as $category => $fields)
                            <option value="{{ $category }}">{{ $category }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success" id="submitRatingField">Save </button>
                </form>
            </div>
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
    document.addEventListener("DOMContentLoaded", function() {
        // Prevent special characters in text fields
        document.querySelectorAll("input[type='text']").forEach((input) => {
            input.addEventListener("keypress", function(e) {
                let regex = /^[a-zA-Z0-9\s]$/; // Allow only letters, numbers, and spaces
                let key = String.fromCharCode(e.keyCode || e.which);

                if (!regex.test(key)) {
                    e.preventDefault(); // Block the key press
                }
            });
        });

        // Star rating functionality
        const ratingContainers = document.querySelectorAll(".rating");

        ratingContainers.forEach((ratingContainer) => {
            const stars = ratingContainer.querySelectorAll("span");
            const hiddenInput = ratingContainer.nextElementSibling;
            const currentRating = ratingContainer.getAttribute("data-rating") || 0;

            // Function to highlight stars based on rating value
            function updateStars(value) {
                stars.forEach((s) => {
                    s.classList.toggle("selected", s.getAttribute("data-value") <= value);
                });
            }

            // Initialize stars on page load based on data-rating
            updateStars(currentRating);
            hiddenInput.value = currentRating; // Ensure the hidden input is set

            stars.forEach((star) => {
                star.addEventListener("click", function() {
                    const value = this.getAttribute("data-value");
                    ratingContainer.setAttribute("data-rating", value);
                    hiddenInput.value = value;
                    updateStars(value);
                });

                star.addEventListener("mouseover", function() {
                    updateStars(this.getAttribute("data-value"));
                });

                star.addEventListener("mouseout", function() {
                    updateStars(ratingContainer.getAttribute("data-rating"));
                });
            });
        });

        // Error message fade out
        const errorMessages = document.querySelectorAll('.error-message');
        errorMessages.forEach((errorMessage) => {
            setTimeout(() => {
                errorMessage.style.opacity = '0';
                errorMessage.style.transform = 'translateX(100%)';
            }, 3000); // Remove error messages after 3 seconds
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

        document.querySelector("#indicatorForm").addEventListener("submit", function(event) {
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
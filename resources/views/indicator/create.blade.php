@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('vendor/full-calendar/main.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/css/bootstrap-colorpicker.css') }}" />
@endpush

@push('datatable-styles')
@include('sections.daterange_css')
@endpush

@section('content')
<form action="{{ route('indicator.store') }}" method="POST" id="indicatorForm">
    @csrf
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
                            <label class="f-14 text-dark-grey mb-12">Branch <sup class="f-14 mr-1">*</sup></label>
                            <select class="form-control height-35 f-14" name="branch" id="branch" required>
                                <option value="" disabled selected>Select Branch</option>
                                @foreach($branchname as $item)
                                <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Department Field -->
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group my-3">
                            <label class="f-14 text-dark-grey mb-12">Department <sup class="f-14 mr-1">*</sup></label>
                            <select class="form-control height-35 f-14" name="department" id="department" fieldname="department" required required>
                                <option value="" disabled selected>Select department</option>
                                @foreach($department as $item)
                                <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Designation Field -->
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group my-3">
                            <label class="f-14 text-dark-grey mb-12">Designation <sup class="f-14 mr-1">*</sup></label>
                            <select class="form-control height-35 f-14" name="designation" id="designation" required>
                                <option value="" disabled selected>Select Designation</option>
                                @foreach($designation as $item)
                                <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    @if (session('error'))
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group my-3">
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                            @if (session('indicator'))
                            <a class="btn btn-primary" href="{{ route('indicator.edit', session('indicator')) }}">Edit</a>
                            @endif
                        </div>
                    </div>
                    @endif

                </div>

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
                        <div class="f-21 col-6">
                            <div class="rating" data-rating="0">
                                <span data-value="1">&#9733;</span>
                                <span data-value="2">&#9733;</span>
                                <span data-value="3">&#9733;</span>
                                <span data-value="4">&#9733;</span>
                                <span data-value="5">&#9733;</span>
                            </div>
                            <input type="hidden" name="ratings[{{ Str::slug($field->field_name, '_') }}]" required>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endforeach

                <button type="submit" class="btn-primary rounded f-14 p-2 mr-3">
                    <i class="fa fa-check mr-1"></i>Save
                </button>
                <a href="{{ route('indicator.index') }}" class="btn-cancel rounded f-14 p-2">Cancel</a>
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

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Prevent special characters in text fields
        document.querySelectorAll("input[type='text']").forEach((input) => {
            input.addEventListener("keypress", function(e) {
                let regex = /^[a-zA-Z0-9\s]+$/; // Allow only letters, numbers, and spaces
                let key = String.fromCharCode(e.keyCode || e.which);
                if (!regex.test(key)) {
                    e.preventDefault();
                }
            });
        });


        // Star rating functionality
        document.querySelectorAll(".rating").forEach(ratingContainer => {
            const stars = ratingContainer.querySelectorAll("span");
            const hiddenInput = ratingContainer.nextElementSibling;

            stars.forEach(star => {
                star.addEventListener("click", function() {
                    const value = this.getAttribute("data-value");
                    ratingContainer.setAttribute("data-rating", value);
                    hiddenInput.value = value;
                    stars.forEach(s => s.classList.toggle("selected", s.getAttribute("data-value") <= value));
                });

                star.addEventListener("mouseover", function() {
                    const value = this.getAttribute("data-value");
                    stars.forEach(s => s.classList.toggle("selected", s.getAttribute("data-value") <= value));
                });

                star.addEventListener("mouseout", function() {
                    const currentRating = ratingContainer.getAttribute("data-rating");
                    stars.forEach(s => s.classList.toggle("selected", s.getAttribute("data-value") <= currentRating));
                });
            });
        });

        // Live validation
        function showValidationMessage(field, message) {
            let errorDiv = field.nextElementSibling;
            if (!errorDiv || !errorDiv.classList.contains("error-message")) {
                errorDiv = document.createElement("div");
                errorDiv.classList.add("error-message");
                field.parentNode.appendChild(errorDiv);
            }
            errorDiv.textContent = message;
        }

        function removeValidationMessage(field) {
            let errorDiv = field.nextElementSibling;
            if (errorDiv && errorDiv.classList.contains("error-message")) {
                errorDiv.remove();
            }
        }

        document.querySelector("#indicatorForm").addEventListener("submit", function(event) {
            let isValid = true;

            document.querySelectorAll("input[required], select[required]").forEach(field => {
                if (!field.value.trim()) {
                    showValidationMessage(field, "This field is required");
                    isValid = false;
                } else {
                    removeValidationMessage(field);
                }
            });

            if (!isValid) {
                event.preventDefault();
            }
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const indicatorForm = document.getElementById("indicatorForm");
        const ratingFieldForm = document.getElementById("ratingFieldForm");

        // Prevent the main form from interfering with modal form submission
        ratingFieldForm.addEventListener("submit", function(event) {
            event.stopPropagation(); // Stops the event from bubbling up to the parent form
        });

        // Ensure indicator form submits correctly
        indicatorForm.addEventListener("submit", function(event) {
            // Add validation logic here if needed
        });
    });
</script>
@endpush

<style>
    .error-message {
        background-color: #ff3a6e;
        color: white;
        padding: 10px;
        border-radius: 5px;
        margin-top: 10px;
        max-width: 50%;
        opacity: 1;
        transition: opacity 0.5s;
    }

    .rating span {
        font-size: 24px;
        cursor: pointer;
        color: #ccc;
    }

    .rating span.selected {
        color: #ffd700;
    }
</style>
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
                            <input type="text" class="form-control height-35 f-14" name="department" id="department" fieldname="department" required>
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
                    <h4 class="mb-0 p-20 f-15 font-weight-normal text-capitalize border-bottom-grey">{{ $category }}</h4>        
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
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Prevent special characters in text fields
        document.querySelectorAll("input[type='text']").forEach((input) => {
            input.addEventListener("keypress", function (e) {
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
                star.addEventListener("click", function () {
                    const value = this.getAttribute("data-value");
                    ratingContainer.setAttribute("data-rating", value);
                    hiddenInput.value = value;
                    stars.forEach(s => s.classList.toggle("selected", s.getAttribute("data-value") <= value));
                });

                star.addEventListener("mouseover", function () {
                    const value = this.getAttribute("data-value");
                    stars.forEach(s => s.classList.toggle("selected", s.getAttribute("data-value") <= value));
                });

                star.addEventListener("mouseout", function () {
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

        document.querySelector("#indicatorForm").addEventListener("submit", function (event) {
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

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
            <h4 class="mb-0 p-20 f-21 font-weight-normal text-capitalize border-bottom-grey">
                @lang('app.menu.indicatorDetials')
            </h4>
            <div class="row p-20">
                <!-- Branch Field -->
                <div class="col-lg-4 col-md-6">
                    <div class="form-group my-3">
                        <label class="f-14 text-dark-grey mb-12">Branch &nbsp;<sup class="f-14 mr-1">*</sup></label>
                        <input type="text" class="form-control height-35 f-14" placeholder="Department"
                            name="department" id="department" value="{{ $indicators->branch }}" readonly>
                    </div>
                </div>

                <!-- Department Field -->
                <div class="col-lg-4 col-md-6">
                    <div class="form-group my-3">
                        <label class="f-14 text-dark-grey mb-12">Department &nbsp;<sup
                                class="f-14 mr-1">*</sup></label>
                        <input type="text" class="form-control height-35 f-14" placeholder="Department"
                            name="department" id="department" value="{{ $indicators->department }}" disabled>
                    </div>
                </div>

                <!-- Designation Field -->
                <div class="col-lg-4 col-md-6">
                    <div class="form-group my-3">
                        <label class="f-14 text-dark-grey mb-12">Designation &nbsp;<sup class="f-14 mr-1">*</sup></label>
                        <input type="text" class="form-control height-35 f-14" placeholder="Department"
                            name="department" id="department" value="{{ $indicators->designation }}" readonly>
                    </div>
                </div>
            </div>

            @php
            $field_ratings = json_decode($indicators->field_ratings, true);
            @endphp

            @foreach ($indicatorheaders as $category => $fields)
            <h4 class="mb-0 p-20 f-15 font-weight-normal text-capitalize border-bottom-grey">{{ $category }}</h4>
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
                    </div>
                </div>
                @endforeach
            </div>
            @endforeach

            <div class="p-20">
                <a href="{{route('indicator.edit',$indicators) }}" class="btn-primary rounded f-14 p-2 mr-3"><i class="fa fa-edit mr-1"></i>edit</a>
                <a href="{{route('indicator.index') }}" class="btn-cancel rounded f-14 p-2 border-0">cancel</a>
            </div>
        </div>
    </div>
</form>
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
        // Star rating functionality for viewing only
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
        });

        // Error message fade out
        const errorMessages = document.querySelectorAll('.error-message');
        errorMessages.forEach((errorMessage) => {
            setTimeout(() => {
                errorMessage.style.opacity = '0';
                errorMessage.style.transform = 'translateX(100%)';
            }, 3000); // Remove error messages after 3 seconds
        });
    });
</script>
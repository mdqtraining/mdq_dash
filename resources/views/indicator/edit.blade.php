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
            <h4 class="mb-0 p-20 f-15 font-weight-normal text-capitalize border-bottom-grey">
                Organizational Competencies</h4>
            <div class="p-20">
                <div class="d-flex p-20" style="align-items: center;">
                    <div class="col-6 text-dark-grey">Leadership</div>
                    <div class="f-21 col-6">
                        <div class="rating" data-rating="0">
                            <span data-value="1">&#9733;</span>
                            <span data-value="2">&#9733;</span>
                            <span data-value="3">&#9733;</span>
                            <span data-value="4">&#9733;</span>
                            <span data-value="5">&#9733;</span>
                        </div>
                    </div>
                </div>
                <div class="d-flex p-20" style="align-items: center;">
                    <div class="col-6 text-dark-grey">Project Management</div>
                    <div class="f-21 col-6">
                        <div class="rating" data-rating="0">
                            <span data-value="1">&#9733;</span>
                            <span data-value="2">&#9733;</span>
                            <span data-value="3">&#9733;</span>
                            <span data-value="4">&#9733;</span>
                            <span data-value="5">&#9733;</span>
                        </div>
                    </div>
                </div>
            </div>
            <h4 class="mb-0 p-20 f-15 font-weight-normal text-capitalize border-bottom-grey">
                Technical Competencies</h4>
            <div class="p-20">
                <div class="d-flex p-20" style="align-items: center;">
                    <div class="col-6 text-dark-grey">Allocating Resources</div>
                    <div class="f-21 col-6">
                        <div class="rating" data-rating="0">
                            <span data-value="1">&#9733;</span>
                            <span data-value="2">&#9733;</span>
                            <span data-value="3">&#9733;</span>
                            <span data-value="4">&#9733;</span>
                            <span data-value="5">&#9733;</span>
                        </div>
                    </div>
                </div>
            </div>
            <h4 class="mb-0 p-20 f-15 font-weight-normal text-capitalize border-bottom-grey">
                Behavioural Competencies</h4>
            <div class="p-20">
                <div class="d-flex p-20" style="align-items: center;">
                    <div class="col-6 text-dark-grey">Business Process</div>
                    <div class="f-21 col-6">
                        <div class="rating" data-rating="0">
                            <span data-value="1">&#9733;</span>
                            <span data-value="2">&#9733;</span>
                            <span data-value="3">&#9733;</span>
                            <span data-value="4">&#9733;</span>
                            <span data-value="5">&#9733;</span>
                        </div>
                    </div>
                </div>
                <div class="d-flex p-20" style="align-items: center;">
                    <div class="col-6 text-dark-grey">Oral Communication</div>
                    <div class="f-21 col-6">
                        <div class="rating" data-rating="0">
                            <span data-value="1">&#9733;</span>
                            <span data-value="2">&#9733;</span>
                            <span data-value="3">&#9733;</span>
                            <span data-value="4">&#9733;</span>
                            <span data-value="5">&#9733;</span>
                        </div>
                    </div>
                </div>
                <x-form-actions>
                    <x-forms.button-primary :link="route('indicator.store')" class="mr-3" icon="check">@lang('app.save')
                    </x-forms.button-primary>
                    <x-forms.button-cancel :link="route('indicator.index')" class="border-0">@lang('app.cancel')
                    </x-forms.button-cancel>
                </x-form-actions>
                
            </div>
        </div>
    </div>
</div>
@endsection

<style>
    .rating span {
    font-size: 24px;
    cursor: pointer;
    color: #ccc; /* Default star color */
    transition: color 0.3s;
}

.rating span.selected {
    color: #ffd700; /* Gold color when selected */
}

</style>

<script>
   document.getElementById('save-indicator-form').addEventListener('click', function (event) {
    event.preventDefault(); // Prevent form submission

    // Get form data
    const formData = new FormData(document.getElementById('indicator-form'));

    // Add CSRF token to form data for security
    formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

    // Send AJAX request with axios
    axios.post("{{ route('indicator.store') }}", formData)
        .then(response => {
            // Handle success
            console.log('Indicator saved successfully', response.data);
            alert('Indicator saved successfully');
        })
        .catch(error => {
            // Handle error
            console.error('Error saving indicator', error);
            alert('There was an error saving the indicator');
        });
});

    document.addEventListener("DOMContentLoaded", function () {
        // Select all the rating containers on the page
        const ratingContainers = document.querySelectorAll(".rating");

        ratingContainers.forEach((ratingContainer) => {
            const stars = ratingContainer.querySelectorAll("span");

            stars.forEach((star) => {
                // Hover effect
                star.addEventListener("mouseover", function () {
                    const value = this.getAttribute("data-value");
                    highlightStars(ratingContainer, value); // Highlight stars based on hover
                });

                // Remove hover effect when mouse leaves
                star.addEventListener("mouseout", function () {
                    const currentRating = ratingContainer.getAttribute("data-rating");
                    highlightStars(ratingContainer, currentRating); // Revert to the selected rating
                });

                // Click to select the rating
                star.addEventListener("click", function () {
                    const value = this.getAttribute("data-value");
                    ratingContainer.setAttribute("data-rating", value); // Update the data-rating attribute
                    highlightStars(ratingContainer, value); // Highlight stars based on the clicked value
                });
            });

            // Highlight stars based on the current rating
            function highlightStars(container, value) {
                const stars = container.querySelectorAll("span");
                stars.forEach((star) => {
                    if (parseInt(star.getAttribute("data-value")) <= parseInt(value)) {
                        star.classList.add("selected");
                    } else {
                        star.classList.remove("selected");
                    }
                });
            }
        });
    });
</script>

@extends('layouts.app')

@section('content')

@push('styles')
    <link rel="stylesheet" href="{{ asset('vendor/full-calendar/main.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/css/bootstrap-colorpicker.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@push('datatable-styles')
    @include('sections.daterange_css')
@endpush

<form action="{{ route('appraisal.store') }}" method="POST" id="appraisalForm">
    @csrf
    <div class="content-wrapper">
        <div class="add-page">
            <div class="p-20">
                @if (session('success'))
                    <div class="alert alert-success mt-4">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger mt-4">{{ session('error') }}</div>
                @endif
                <script>
                    setTimeout(() => {
                        document.querySelectorAll('.alert').forEach(alert => alert.remove());
                    }, 10000);
                </script>

                <h4 class="mb-0 p-20 f-21 font-weight-normal text-capitalize border-bottom-grey">
                    @lang('app.menu.indicatorDetails')
                </h4>

                <div class="row p-20">
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group my-3">
                            <label class="f-14 text-dark-grey mb-12">Branch <sup class="f-14 mr-1">*</sup></label>
                            <input class="form-control height-35 f-14 bg-white" disabled value="{{$appraisal->branch}}">
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="form-group my-3">
                            <label class="f-14 text-dark-grey mb-12">Employee <sup class="f-14 mr-1">*</sup></label>
                            <input class="form-control height-35 f-14 bg-white" disabled value="{{$appraisal->employee_name}}">
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4" id="deadlineBox">
                    <label for="monthYearPicker" class="f-14 text-dark-grey mb-12">Select Month and Year <sup>*</sup></label>
                    <input class="form-control height-35 f-14 bg-white" value="{{$appraisal->appraisal_date}}" disabled>
                </div>

                <div class="col-md-12 col-lg-6" id="remarkBox">
                    <div class="form-group my-3">
                        <label class="f-14 text-dark-grey mb-12" for="remarkInput">Remark</label>
                        <textarea id="remarkInput" name="remark" value="{{$appraisal->remark}}" class="form-control height-35 f-14 bg-white" disabled></textarea>
                    </div>
                </div>



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
        document.addEventListener("DOMContentLoaded", function () {
            flatpickr("#monthYearPicker", {
                dateFormat: "m/Y",
                allowInput: true,
                disableMobile: true
            });
        });
    </script>
@endpush

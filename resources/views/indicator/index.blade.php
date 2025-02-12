
@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('vendor/full-calendar/main.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/css/bootstrap-colorpicker.css') }}" />
@endpush

@push('datatable-styles')
@include('sections.daterange_css')
@endpush

@section('filter-section')

@include('indicator.filters')

@endsection


@section('content')
<div class="content-wrapper">
<div class="d-block d-lg-flex d-md-flex justify-content-between action-bar">
        <div id="table-actions" class="flex-grow-1 align-items-center">

            <x-forms.link-primary :link="route('indicator.create')"      class="mr-3 float-left mb-2 mb-lg-0 mb-md-0" icon="plus">
                Add Indicator
            </x-forms.link-primary>
            <x-forms.link-secondary :link="route('indicator.index')" class="mr-3 openRightModal float-left mb-2 mb-lg-0 mb-md-0" icon="file-upload">
                Import
            </x-forms.link-secondary>
            <x-forms.link-secondary :link="route('indicator.index')" class="mr-3 openRightModal float-left mb-2 mb-lg-0 mb-md-0" icon="file-export">
                Export
            </x-forms.link-secondary>
        
        </div>
        
        <div class="btn-group mt-2 mt-lg-0 mt-md-0 ml-0 ml-lg-3 ml-md-3" role="group">
            <a href="{{ route('indicator.index') }}" class="btn btn-secondary f-14 btn-active" data-toggle="tooltip" data-original-title="@lang('modules.leaves.tableView')">
                <i class="side-icon bi bi-list-ul"></i>
            </a>
            <!-- <a href="{{ route('indicator.index') }}" class="btn btn-secondary f-14" data-toggle="tooltip" data-original-title="@lang('modules.lead.kanbanboard')">
                <i class="side-icon bi bi-kanban"></i></a> -->
        </div>
    </div>
    @if (session('success'))
        <div class="alert alert-success mt-4" >
           {{ session('success') }}
        </div>
        @endif

        @if (session('error'))
        <div class="alert alert-danger mt-4">
            {{ session('error') }}
        </div>
        @endif
        @include('indicator.IndicatorDataTable')
    </div>
@endsection
@push('scripts')
<script>
    setTimeout(() => {
        document.querySelectorAll('.alert').forEach(alert => alert.remove());
    },10000); // Message disappears after 3 seconds
</script>
@endpush
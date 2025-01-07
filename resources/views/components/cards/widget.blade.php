@php
    $styles = [
        'Total Clients' => 'padding: 10px; border-radius:10px; background-color: #6FD943;',
        'Total Employees' => 'padding: 10px; border-radius:10px; background-color: rgb(255,162,29);',
        'Total Projects' => 'padding: 10px; border-radius:10px; background-color: rgb(62,201,214);',
        'Due Invoices' => 'padding: 10px; border-radius:10px; background-color: #ff3a6e;',
        'Hours Logged' => 'padding: 10px; border-radius:10px; background-color:  #6FD943;',
        'Pending Tasks' => 'padding: 10px; border-radius:10px; background-color: rgb(255,162,29);',
        'Today Attendance' => 'padding: 10px; border-radius:10px; background-color:rgb(62,201,214);',
        'Unresolved Tickets' => 'padding: 10px; border-radius:10px; background-color:  #ff3a6e;',
        'Overdue Projects' => 'padding: 10px; border-radius:10px; background-color: rgb(255,162,29);',
        'Total Leads' => 'padding: 10px; border-radius:10px; background-color: rgb(255,162,29);',
        'Lead Conversions' => 'padding: 10px; border-radius:10px; background-color:rgb(62,201,214);',
        'Contracts Generated' => 'padding: 10px; border-radius:10px; background-color:  #ff3a6e;',
        'Leaves Approved' => 'padding: 10px; border-radius:10px; background-color:  #ff3a6e;',
        'Employee Exits' => 'padding: 10px; border-radius:10px; background-color: rgb(255,162,29);',
        'Average Attendance' => 'padding: 10px; border-radius:10px; background-color:  #ff3a6e;',
        'Total Pending Amount' => 'padding: 10px; border-radius:10px; background-color: rgb(255,162,29);',
        'Closed Tickets' => 'padding: 10px; border-radius:10px; background-color:  #6FD943;',
        'Open Tickets' => 'padding: 10px; border-radius:10px; background-color: rgb(255,162,29);',
        'Pending Tickets' => 'padding: 10px; border-radius:10px; background-color:  #ff3a6e;',
        'Resolved Tickets' => 'padding: 10px; border-radius:10px; background-color:  #6FD943;',
        'Working Days' => 'padding: 10px; border-radius:10px; background-color:  #6FD943;',
        'Days Present' => 'padding: 10px; border-radius:10px; background-color:  #6FD943;',
        'Late' => 'padding: 10px; border-radius:10px; background-color: rgb(255,162,29);',
        'Half Day' => 'padding: 10px; border-radius:10px; background-color: rgb(255,162,29);',
        'Absent' => 'padding: 10px; border-radius:10px; background-color:  #ff3a6e;'
        
    ];
    $style = $styles[$title] ?? 'padding: 10px; border-radius:10px; background-color:rgb(62,201,214);';
    $styles1 = [
        'Total Clients' => 'color: #6FD943;',
        'Total Employees' => 'color: rgb(255,162,29);',
        'Total Projects' => 'color: rgb(62,201,214);',
        'Due Invoices' => 'color: #ff3a6e;',
        'Hours Logged' => 'color: #6FD943;',
        'Pending Tasks' => 'color:rgb(255,162,29);',
        'Today Attendance' => ' color:rgb(62,201,214);',
        'Unresolved Tickets' => ' color: #ff3a6e;',
        'Overdue Projects' => 'color: rgb(255,162,29);',
        'Total Leads' => 'color: rgb(255,162,29);',
        'Lead Conversions' => 'color:rgb(62,201,214);',
        'Contracts Generated' => 'color:  #ff3a6e;',
        'Leaves Approved' => 'color:  #ff3a6e;',
        'Employee Exits' => 'color: rgb(255,162,29);',
        'Average Attendance' => 'color:  #ff3a6e;',
        'Total Pending Amount' => 'color: rgb(255,162,29);',
        'Closed Tickets' => 'color:  #6FD943;',
        'Open Tickets' => 'color: rgb(255,162,29);',
        'Pending Tickets' => 'color:  #ff3a6e;',
        'Resolved Tickets' => 'color:  #6FD943;',
        'Working Days' => 'color:  #6FD943;',
        'Days Present' => 'color:  #6FD943;',
        'Late' => 'color: rgb(255,162,29);',
        'Half Day' => 'color: rgb(255,162,29);',
        'Absent' => 'color:  #ff3a6e;'
    ];
    $style1 = $styles1[$title] ?? 'color:rgb(62,201,214);';
@endphp

<div
    {{ $attributes->merge(['class' => 'bg-white p-20 rounded b-shadow-4 d-flex justify-content-between align-items-center br-10']) }}>
    <div class="d-block"  style="{{ $style }}">
        <i class="fa fa-{{ $icon }} text-white f-18"></i>
    </div>
    <div class="d-block text-capitalize">
        <h5 class="f-15 f-w-500 mb-20 text-darkest-grey">{{ $title }}
            @if (!is_null($info))
            <i class="fa fa-question-circle" data-toggle="popover" data-placement="top" data-content="{{ $info }}" data-html="true" data-trigger="hover"></i>
        @endif
        </h5>
        <div class="d-flex">
            <p class="mb-0 f-15 font-weight-bold d-grid" style="{{ $style1 }}"><span
                    id="{{ $widgetId }}">{{ $value }}</span>
            </p>
        </div>
    </div>
</div>

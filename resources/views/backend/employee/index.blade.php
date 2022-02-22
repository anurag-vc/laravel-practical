@extends('backend.layouts.app')
<link href="{{ asset('css/table.css') }}" rel="stylesheet">

@section('content')
<a class="add-button" href="{{ route('employee.create') }}" data-toggle="tooltip" data-placement="bottom" title="Delete">
    <button class="btn btn-primary">@lang('label.employee.add')</button>
</a>

<h2>@lang('label.employee.table_header')</h2>
    <div class="table-container">
      <table class="table-rwd">
        <tr>
            <th>@lang('label.employee.index')</th>
            <th>@lang('label.employee.id')</th>
            <th>@lang('label.employee.first_name')</th>
            <th>@lang('label.employee.last_name')</th>
            <th>@lang('label.employee.company')</th>
            <th>@lang('label.employee.email')</th>
            <th>@lang('label.employee.phone')</th>
            <th>@lang('label.employee.action')</th>
        </tr>
        @if (!empty($employees)) 
            @foreach ($employees as $index => $employee)
            <tr>
                <td>{{ $index +1 }}</td>  
                <td>{{ $employee['id'] ?? "-" }}</td>
                <td>{{ $employee['first_name'] ?? "-" }}</td>
                <td>{{ $employee['last_name'] ?? "-" }}</td>
                <td>{{ $employee['company']['name'] ?? "-" }}</td>
                <td>{{ $employee['email'] ?? "-" }}</td>
                <td>{{ $employee['phone'] ?? "-" }}</td>
                <td>@include('backend.employee.includes.actions')</td>
            </tr>
           @endforeach
        @endif
      </table>
    </div>
    
    <div class="pagination">
      {!! $employees->render() !!}
    </div>
@endsection
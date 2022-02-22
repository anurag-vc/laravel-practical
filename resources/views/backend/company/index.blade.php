@extends('backend.layouts.app')
<link href="{{ asset('css/table.css') }}" rel="stylesheet">

@section('content')
<a class="add-button" href="{{ route('company.create') }}" data-toggle="tooltip" data-placement="bottom" title="Delete">
    <button class="btn btn-primary">@lang('label.company.add')</button>
</a>

<h2>@lang('label.company.table_header')</h2>
    <div class="table-container">
      <table class="table-rwd">
        <tr>
            <th>@lang('label.company.index')</th>
            <th>@lang('label.company.id')</th>
            <th>@lang('label.company.logo')</th>
            <th>@lang('label.company.name')</th>
            <th>@lang('label.company.email')</th>
            <th>@lang('label.company.website')</th>
            <th>@lang('label.company.action')</th>
        </tr>
        @if (!empty($companies)) 
            @foreach ($companies as $index => $company)
            <tr>
              <td>{{ $index +1 }}</td>  
              <td>{{ $company->id ?? "-"}}</td>
                
                @if ($company->logo)
                  <td><img src="{{ asset(env('IMAGE_PATH').$company->logo) }}" height="50" width="60"></td>
                @else 
                  <td><img src="{{ asset('images/no_image.jpg') }}" height="60" width="60" data-toggle="tooltip" title="No Image Selected"></td>
                @endif
                
                <td>{{ $company->name ?? "-"}}</td>
                <td>{{ $company->email ?? "-"}}</td>
                <td>{{ $company->website ?? "-"}}</td>
                <td>@include('backend.company.includes.actions')</td>
            </tr>
           @endforeach
        @endif
      </table>
    </div>

    <div class="pagination">
      {!! $companies->render() !!}
    </div>
@endsection
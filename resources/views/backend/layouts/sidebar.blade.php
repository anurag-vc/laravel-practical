<link href="{{ asset('css/sidebar.css') }}" rel="stylesheet">

<div class="sidebar">
    <div>
        <a class="{{ Request::routeIs('company.*') ? 'active' : '' }}" href="{{ route('company.index') }}">@lang('label.sidebar.company_management')</a>
        <a class="{{ Request::routeIs('employee.*') ? 'active' : '' }}" href="{{ route('employee.index') }}">@lang('label.sidebar.employee_management')</a>
    </div>
</div>

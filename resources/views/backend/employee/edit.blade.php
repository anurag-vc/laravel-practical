@extends('backend.layouts.app')
<link href="{{ asset('css/form.css') }}" rel="stylesheet">

 @section('content')
    <div class="row">
        <div class="col-md-12">
            {{ Form::model($employee,['route' =>  ['employee.update', $employee->id],'method' => 'PATCH', 'id' => 'editEmployeeForm', 'files' => true]) }}
                @include('backend.employee.partials._form')
            {{ Form::close() }}
        </div>
    </div>
@endsection

@push('after-scripts')
<script type="text/javascript">
  $(document).ready(function () {
    $('#editEmployeeForm').validate({ // initialize the plugin
      rules: {
        first_name: {
          required: true,
        },
        last_name: {
          required: true,
        },
        email: {
          email: true
        },
        phone: {
          number: true,
          maxlength:10
        },
      },    
    });    
  });
</script>
@endpush
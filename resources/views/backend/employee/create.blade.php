@extends('backend.layouts.app')
<link href="{{ asset('css/form.css') }}" rel="stylesheet">

 @section('content')
    <div class="row">
        <div class="col-md-12">
            {{ Form::open(['route' => 'employee.store', 'id' => 'createEmployeeForm']) }}
                @include('backend.employee.partials._form')
            {{ Form::close() }}
        </div>
    </div>
@endsection

<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script type="text/javascript">
  $(document).ready(function () {
    $('#createEmployeeForm').validate({ // initialize the plugin
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
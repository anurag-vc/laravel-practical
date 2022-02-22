@extends('backend.layouts.app')
<link href="{{ asset('css/form.css') }}" rel="stylesheet">

 @section('content')
    <div class="row">
        <div class="col-md-12">
            {{ Form::open(['route' => 'company.store', 'id' => 'createCompanyForm', 'files' => true]) }}
                @include('backend.company.partials._form')
            {{ Form::close() }}
        </div>
    </div>
@endsection

<!-- JQuery validation -->
<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script type="text/javascript">
  $(document).ready(function () {
    $('#createCompanyForm').validate({ // initialize the plugin
      rules: {
        name: {
          required: true,
        },
        email: {
          email: true
        },
      },    
    });    
  });
</script>
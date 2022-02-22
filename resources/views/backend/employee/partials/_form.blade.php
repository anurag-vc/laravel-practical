<h2> @lang('label.employee.header') </h2>
<fieldset>
    <div>
        <label for="first_name">@lang('label.employee.first_name')<span class="text-danger">*</span></label>
        {{ Form::text('first_name',null,['class' => $errors->has('first_name') ? 'form-control is-invalid' : 'form-control']) }}
        @error('first_name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label for="last_name">@lang('label.employee.last_name')<span class="text-danger">*</span></label>
        {{ Form::text('last_name',null,['class' => $errors->has('last_name') ? 'form-control is-invalid' : 'form-control']) }}
        @error('last_name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="mb-3">
        <label for="company">@lang('label.employee.company')</label>
        {{ Form::select('company',!empty($companies) ? $companies : null, isset($employee->company) ? $employee->company : null),['class' => 'form-control select2','placeholder' => 'Sample placeholder'] }}
    </div>

    <div>
        <label for="email">@lang('label.employee.email')</label>
        {{ Form::text('email',null,['class' => $errors->has('email') ? 'form-control is-invalid' : 'form-control']) }}
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label for="phone">@lang('label.employee.phone')</label>
        {{ Form::text('phone',null,['class' => $errors->has('phone') ? 'form-control is-invalid' : 'form-control']) }}
        @error('phone')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</fieldset>

<button class="mt-2" type="submit">
    @if(\Request::route()->getName() == 'employee.edit')
        @lang('label.buttons.update')
    @else
        @lang('label.buttons.add')
    @endif
</button>
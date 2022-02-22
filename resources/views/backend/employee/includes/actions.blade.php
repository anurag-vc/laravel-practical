<link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}" >

<!-- Edit Button -->
<a class="btn btn-primary btn-sm mr-2" href="{{ route('employee.edit', $employee) }}" data-toggle="tooltip" data-placement="bottom" title="Edit">
	<i class="fa fa-pencil"></i>
</a>

<!-- Delete Button -->
<a class="btn btn-danger btn-sm ml-2" href="#deleteModal{{$employee['id']}}" class="trigger-btn" data-bs-toggle="modal">
	<i class="fa fa-trash"></i>
</a>

<!-- Delete Popup -->
<div class="modal fade" id="deleteModal{{$employee['id']}}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteModalLabel">@lang('label.employee.modal_heading')</h5>
        </div>
        <div class="modal-body" style="text-align: left">
          @lang('label.employee.delete_popup'){{isset($employee['first_name']) ? $employee['first_name'] : null}}?
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('label.buttons.cancel')</button>
          
          <form action="{{ route('employee.destroy', $employee) }}" method="post">
            @csrf
            @method('DELETE')
              <button type="submit" class="btn btn-danger">@lang('label.buttons.delete')</button>
          </form>
        </div>
      </div>
    </div>
</div>
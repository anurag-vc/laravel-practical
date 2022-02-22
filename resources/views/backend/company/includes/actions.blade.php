<link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}" >

<!-- Edit Button -->
<a class="btn btn-primary btn-sm mr-2" href="{{ route('company.edit', $company) }}" data-toggle="tooltip" data-placement="bottom" title="Edit">
	<i class="fa fa-pencil"></i>
</a>

<!-- Delete Button -->
<a class="btn btn-danger btn-sm ml-2" href="#deleteModal{{$company->id}}" class="trigger-btn" data-bs-toggle="modal">
	<i class="fa fa-trash"></i>
</a>

<!-- Delete Popup -->
<div class="modal fade" id="deleteModal{{$company->id}}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteModalLabel">@lang('label.company.modal_heading')</h5>
        </div>
        <div class="modal-body" style="text-align: left">
          @lang('label.company.delete_popup'){{isset($company->name) ? $company->name : null}}?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('label.buttons.cancel')</button>
          
          <form action="{{ route('company.destroy', $company) }}" method="post">
            @csrf
            @method('DELETE')
              <button type="submit" class="btn btn-danger">@lang('label.buttons.delete')</button>
          </form>
        </div>
      </div>
    </div>
</div>
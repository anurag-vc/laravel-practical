<h2> @lang('label.company.header') </h2>
<fieldset>
    <div>
        <label for="name">@lang('label.company.name')<span class="text-danger">*</span></label>
        {{ Form::text('name',null,['class' => $errors->has('name') ? 'form-control is-invalid' : 'form-control']) }}
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    
    <div>
        <label for="email">@lang('label.company.email')</label>
        {{ Form::text('email',null,['class' => $errors->has('email') ? 'form-control is-invalid' : 'form-control']) }}
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label for="website">@lang('label.company.website')</label>
        {{ Form::text('website',null,['class' => $errors->has('website') ? 'form-control is-invalid' : 'form-control']) }}
        @error('website')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label>@lang('label.company.logo')</label>
        <input type="file" id="logo" name="logo" class="{{$errors->has('logo') ? 'form-control is-invalid' : 'form-control'}}">
        @error('logo')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>    
</fieldset>

<button class="mt-2" type="submit">
    @if(\Request::route()->getName() == 'company.edit')
        @lang('label.buttons.update')
    @else
        @lang('label.buttons.add')
    @endif
</button>

<!-- Image validation -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script>
    var _URL = window.URL || window.webkitURL;
    $("#logo").change(function(input) {
      img = new Image();
      var file = $(this)[0].files[0];
      console.log(file);
      var imgwidth = 0;
      var imgheight = 0;
      var maxwidth = 100;
      var maxheight = 100;
      img.src = _URL.createObjectURL(file);
      img.onload = function() {
        imgwidth = this.width;
        imgheight = this.height;
        if(imgwidth < maxwidth && imgheight < maxheight){
          alert('Image size must be minimum 100x100');
          $("#logo").val(null);
        }else{
          // 
        }
      }
    });
  </script>
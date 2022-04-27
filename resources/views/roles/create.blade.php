<div class="conatiner">


{!! Form::open(array('route' => 'roles.store','id'=>'addnewRole','method'=>'POST')) !!}
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Name:</strong>
            {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control f-control name','id'=>'name')) !!}
            <span class="text-danger error error_name"></span>
        </div>

    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Permission:</strong>
            <br/>
            <div class="form-check">
             
           
            @foreach($permission as $value)
            <label class="form-check-label">
                <input type="checkbox" class="form-check-input f-control permission" name="permission[]" id="permission" value="{{ $value->id}}" >
                {{ $value->name }}
              </label>
            <br/>
            @endforeach
            <span class="text-danger error error_permission"></span>
         </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <button type="submit" class="btn bg-green float-right">Submit</button>
    </div>
</div>
{!! Form::close() !!}


</div>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#addnewRole').submit(function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        $('.error').text('');
        $('.f-control').removeClass('is-invalid')
        $('.submit button').addClass('disabled');

        $.ajax({
            type: 'POST',
            url: "{{ route('roles.store') }}",
            data: formData,
            contentType: false,
            processData: false,
            success: (response) => {
                console.log(response);
                if (response.status==0) {

             Toast.fire({icon: 'error',title: 'Something gone wrong!'});
              $('.submit button').removeClass('disabled');
             }
               else{ 
                Toast.fire({icon: 'success',title: 'Role Added successfuly!'});
                    $("#addRoleModal").modal("hide");
                  
                }
            },
            error: function(response) {
                
                $('.submit button').removeClass('disabled');
                $.each(response.responseJSON.errors, function(key, val) {
                     $('.'+key).addClass('is-invalid');
                    $('.error_' + key).html(val);
                });

            }
        });

    });
   
</script>

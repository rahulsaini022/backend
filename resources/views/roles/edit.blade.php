


{!! Form::model($role, ['method' => 'PATCH','id'=>'editRole','url' => [Auth::user()->roles[0]->name.'/roles/'. $role->id]]) !!}
{{-- <form action="" method='POST' id='editRole'>  --}}
@csrf
@method('PATCH')
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Name:</strong>
            {!! Form::text('name',$role->name, array('placeholder' => 'Name','class' => 'form-control')) !!}
            <span class="text-danger error error_name"></span>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Permission:</strong>
            <br/>
            @foreach($permission as $value)
                <label>{{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, array('class' => 'name')) }}
                {{ $value->name }}</label>
            <br/>
            @endforeach
            <span class="text-danger error error_permission"></span>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center submit">
        <button type="submit" class="btn bg-green float-right">Submit</button>
    </div>
</div>
{!! Form::close() !!}

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#editRole').submit(function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        $('.error').text('');
      
        $('.submit button').addClass('disabled');

        $.ajax({
            type: 'POST',
            url: "{{url(Auth::user()->roles[0]->name.'/roles/'. $role->id)}}",
            data: formData,
            contentType: false,
            processData: false,
            success: (response) => {
                
                if (response.status==0) {
                    Toast.fire({icon: 'error',title: 'Something gone wrong!'});
              $('.submit button').removeClass('disabled');
             }
               else{ 
                Toast.fire({icon: 'success',title: 'role Data updated successfuly!'});
                    $("#editRoleModal").modal("hide");
                   
                }
            },
            error: function(response) {
              
                $('.submit button').removeClass('disabled');
                $.each(response.responseJSON.errors, function(key, val) {
                     
                    $('.error_' + key).html(val);
                });

            }
        });

    });
   
</script>


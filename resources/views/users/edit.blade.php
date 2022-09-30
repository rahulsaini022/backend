<div class="container">
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Edit New User</h2>
        </div>
       
    </div>
</div>




{!! Form::model($user, ['method' => 'PATCH','id'=>'editUserForm','url' => [Auth::user()->roles[0]->name.'/users/'. $user->id]]) !!}
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Name:</strong>
            {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
            <span class="text-danger error error_name"></span>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Email:</strong>
            {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control')) !!}
            <span class="text-danger error error_email"></span>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Password:</strong>
            {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control')) !!}
            <span class="text-danger error error_password"></span>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Confirm Password:</strong>
            {!! Form::password('confirm-password', array('placeholder' => 'Confirm Password','class' => 'form-control')) !!}
            <span class="text-danger error error_confirm-password"></span>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Role:</strong>
            {!! Form::select('roles[]', $roles,$userRole, array('class' => 'form-control','multiple')) !!}
            <span class="text-danger error error_roles"></span>
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

    $('#editUserForm').submit(function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        $('.error').text('');
      
        $('.submit button').addClass('disabled');

        $.ajax({
            type: 'POST',
            url: "{{url(Auth::user()->roles[0]->name.'/users/'. $user->id) }}",
            data: formData,
            contentType: false,
            processData: false,
            success: (response) => {
                
                if (response.status==0) {
                    Toast.fire({icon: 'error',title: 'Something gone wrong!'});
              $('.submit button').removeClass('disabled');
             }
               else{ 
                Toast.fire({icon: 'success',title: 'user Data updated successfuly!'});
                    $("#editUserModal").modal("hide");
                   
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



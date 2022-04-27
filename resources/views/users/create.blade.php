<div class="container">
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Create New User</h2>
        </div>
    
    </div>
</div>




{!! Form::open(array('route' => 'users.store','method'=>'POST','id'=>'AddUserForm')) !!}
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Name:</strong>
            {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control','id'=>'name')) !!}
            <span class="text-danger error error_name"></span>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Email:</strong>
            {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control','id'=>'email')) !!}
            <span class="text-danger error error_email"></span>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Password:</strong>
            {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control','id'=>'password')) !!}
            <span class="text-danger error error_password"></span>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Confirm Password:</strong>
            {!! Form::password('confirm-password', array('placeholder' => 'Confirm Password','class' => 'form-control','id'=>'confirm-password')) !!}
            <span class="text-danger error error_confirm-password"></span>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Role:</strong>
            {!! Form::select('roles[]', $roles,[], array('class' => 'form-control','id'=>'roles','multiple')) !!}
            <span class="text-danger error error_roles"></span>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center submit">
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

    $('#AddUserForm').submit(function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        $('.error').text('');
        $('.form-control').removeClass('is-invalid');
      
        $('.submit button').addClass('disabled');

        $.ajax({
            type: 'POST',
            url: "{{ route('users.store') }}",
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
                Toast.fire({icon: 'success',title: 'User Create successfuly!'});
                    $("#addUserModal").modal("hide");
                  
                }
            },
            error: function(response) {
                
                $('.submit button').removeClass('disabled');
                $.each(response.responseJSON.errors, function(key, val) {
                     $('#'+key).addClass('is-invalid');
                    $('.error_' + key).html(val);
                });

            }
        });

    });
   
</script>



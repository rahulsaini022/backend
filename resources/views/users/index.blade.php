@extends('layouts.app')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Users Management</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success add-new-user" > Create New User</a>
            </div>
        </div>
    </div>


    @if ($message = Session::get('success'))
    <script>  Toast.fire({icon: 'success',title: '{{$message}}'})</script>
  @endif


    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Email</th>
            <th>Roles</th>
            @can('change-status') <th>Status</th>@endcan
            <th width="280px">Action</th>
        </tr>
        @foreach ($data as $key => $user)
            <tr>
                <td>{{ ++$i ?? '' ?? '' }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    @if (!empty($user->getRoleNames()))
                        @foreach ($user->getRoleNames() as $v)
                            <label class="badge badge-success">{{ $v }}</label>
                        @endforeach
                    @endif
                </td>
                @can('change-status')  <td class="slideBtnOuter"><span class="d-none">{{ $user->status }}</span>
                    <div class="slideToggleOuter">
                        <input type="checkbox" {{ $user->status ? 'checked' : '' }} data-id="{{ $user->id }}"
                            class="cm-toggle">
                        <span class="text">Pending</span>
                        <span class="text">Active</span>
                    </div>
                </td>
             @endcan

                <td>
                    <a class="btn btn-info show-user" data-id="{{ $user->id}}">Show</a>
                    @can('user-edit')
                        <a class="btn btn-primary edit-user" data-id="{{ $user->id}}">Edit</a>
                    @endcan
                    @can('user-delete')
                        {!! Form::open(['method' => 'DELETE', 'route' => ['users.destroy', $user->id], 'style' => 'display:inline']) !!}
                        {!! Form::submit('Delete', ['onclick'=>'return confirm("You want to delete user")','class' => 'btn btn-danger']) !!}
                        {!! Form::close() !!}
                    @endcan
                </td>
            </tr>
        @endforeach
    </table>

    <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLebal" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header bg-green">
                  <h3 class="modal-title" id="addUserModalLebal" style="width:100%;">Add New user
                      <button type="button" class="close" title="Close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </h3>
              </div>
              <div class="modal-body">
                  Loading...
              </div>
          </div>
      </div>
  </div>
  <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLebal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-green">
                <h3 class="modal-title" id="editUserModalLebal" style="width:100%;">Edit User
                    <button type="button" class="close" title="Close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </h3>
            </div>
            <div class="modal-body">
                Loading...
            </div>
        </div>
    </div>
</div>
  <div class="modal fade" id="showUserModal" tabindex="-1" role="dialog" aria-labelledby="showUserModalLebal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-green">
                <h3 class="modal-title" id="showUserModalLebal" style="width:100%;">User 
                    <button type="button" class="close" title="Close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </h3>
            </div>
            <div class="modal-body">
                Loading...
            </div>
        </div>
    </div>
</div>

    {{ $data->links('vendor.pagination.Custom')  }}

    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.cm-toggle').change(function() {
                var status = $(this).prop('checked') == true ? 1 : 0;
                var user_id = $(this).data('id');
                $.ajax({
                    type: "Post",
                    dataType: "json",
                    url: "{{ url('/status') }}",
                    data: {
                        'status': status,
                        'id': user_id,
                    },
                    success: function(data) {
          console.log(data);
                        Toast.fire({icon: 'success',title: data.success})
                    },
                    error: function(data) {

                        Toast.fire({icon: 'error',title: data.statusText})
                    },
                });
            });
            



        })
        $(document).on('click', '.add-new-user', function(){
            target = '{{ url("/users/create") }}';
           
	      	$("#addUserModal .modal-body").load(target, function() {$("#addUserModal").modal("show"); });
        });
       
            $(document).on('click', '.edit-user', function(){
                user_id = $(this).data('id');
               
                target = '{{ url("/users") }}/'+user_id+'/edit';
             
                $("#editUserModal .modal-body").load(target, function() {$("#editUserModal").modal("show"); });
            });
            $(document).on('click', '.show-user', function(){
                user_id = $(this).data('id');
               
                target = '{{ url("/users") }}/'+user_id;
             
                $("#showUserModal .modal-body").load(target, function() {$("#showUserModal").modal("show"); });
            });
            $(function() {
            $('#addUserModal, #editUserModal').on('hide.bs.modal', function () {
              window.location.reload();
            });

        })
        $(document).on('click', '.close', function(){
            $('.modal').modal('hide');
        });
    </script>
@endsection

@extends('layouts.app')


@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Role Management</h2>
        </div>
        <div class="pull-right">
        @can('role-create')
            <a class="btn btn-success add-new-role"> Create New Role</a>
            @endcan
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
     <th width="280px">Action</th>
  </tr>
    @foreach ($roles as $key => $role)
    <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $role->name }}</td>
        <td>
            <a class="btn btn-info show-role" data-id="{{$role->id}}">Show</a>
            @can('role-edit')
                <a class="btn btn-primary edit-role" data-id="{{$role->id}}" >Edit</a>
            @endcan
            @can('role-delete')
                {!! Form::open(['method' => 'DELETE','route' => ['roles.destroy', $role->id],'style'=>'display:inline']) !!}
                    {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                {!! Form::close() !!}
            @endcan
        </td>
    </tr>
    @endforeach
</table>


<div class="modal fade" id="addRoleModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLebal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-green">
                <h3 class="modal-title" id="addUserModalLebal" style="width:100%;">Add New role
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
<div class="modal fade" id="editRoleModal" tabindex="-1" role="dialog" aria-labelledby="editRoleModalLebal" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header bg-green">
              <h3 class="modal-title" id="editRoleModalLebal" style="width:100%;">Edit role
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
<div class="modal fade" id="showRoleModal" tabindex="-1" role="dialog" aria-labelledby="showRoleModalLebal" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header bg-green">
              <h3 class="modal-title" id="showRoleModalLebal" style="width:100%;">role 
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

  {!! $roles ?? ''->render() !!}

  <script>
   

    
      $(document).on('click', '.add-new-role', function(){
          target = '{{ url("/roles/create") }}';
         
            $("#addRoleModal .modal-body").load(target, function() {$("#addRoleModal").modal("show"); });
      });
     
          $(document).on('click', '.edit-role', function(){
              role_id = $(this).data('id');
             
              target = '{{ url("/roles") }}/'+role_id+'/edit';
           
              $("#editRoleModal .modal-body").load(target, function() {$("#editRoleModal").modal("show"); });
          });
          $(document).on('click', '.show-role', function(){
              role_id = $(this).data('id');
             
              target = '{{ url("/roles") }}/'+role_id;
           
              $("#showRoleModal .modal-body").load(target, function() {$("#showRoleModal").modal("show"); });
          });
          $(function() {
          $('#addRoleModal, #editRoleModal').on('hide.bs.modal', function () {
            window.location.reload();
          });

      })
      $(document).on('click', '.close', function(){
          $('.modal').modal('hide');
      });

  </script>



@endsection
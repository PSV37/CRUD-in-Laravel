@extends('layouts.app')
@section('content')
<?php $array_staus=unserialize(STATUS); ?>
<div class="container" id="main_div">
    <div class="row">
        <div class="col-md-2 ">
            <div class="panel panel-default">
                <div class="panel-heading">Sidebar
                </div>
                <?php if ( Auth::user()->role_id ==1){ ?>
                <div class="panel-heading"><a href="{{ route('all') }}">Users</a>
            </div>
            <?php }  ?>
            
        </div>
    </div>
    <div class="col-md-10 ">
        <div class="panel panel-default " style="min-height: 400px;">
            <div class="panel-heading">All Users</div>
            <div class="success_div" style="width: 91%;margin-left: 34px;text-align: center;">
                                
            </div>
            <table class="table table-bordered" id="users-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <div class="loader-ajax" id="loader-icon" style="display:none;position: fixed;top: 40%;width: 25%;height: 100%;text-align: center;z-index: 100000;display:none;left:40%">
                        <img src="{{ asset('images/loading1.gif')}}" />
                    </div>
                     <input type="hidden" value="{{ csrf_token() }}" id="_token" name="_token" />
                    @foreach($arrray_user_data as $user)
                    <tr id="user_row_{{$user->id}}">
                        <td>{{ $user->fname}}</td>
                        <td>{{ $user->email}}</td>
                        <td>{{ $user->role->role_name}}</td>
                        <td>{{ $user->created_at}}</td>
                        <td>{{ isset($user->status) ?'Active':'Inactive' }}</td>
                        <td> <i class="fa fa-pencil-square-o record_edit" value='{{ $user->id }}' style="margin-right:  10px; cursor:pointer" aria-hidden="true"></i><i class="fa fa-trash-o delete_id" aria-hidden="true"  value='{{ $user->id }}' style="cursor:pointer"></i></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- Modal -->
            <div id="myModal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Modal Header</h4>
                            <div class="success_div" style="width: 91%;margin-left: 34px;text-align: center;">
                                
                            </div>
                        </div>
                        <div class="modal-body">
                <form class="form-horizontal" method="POST" id="form-horizontal" action="{{ route('register') }}">
                        {{ csrf_field() }}
                      <input type="hidden" name="baseUrl"  id="baseUrl" value="{{url('delete')}}">
                        <div class="form-group{{ $errors->has('fname') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">First Name</label>
                            <div class="col-md-6">
                                <input id="fname" type="text" class="form-control" name="fname" value="{{ old('fname') }}" required autofocus>
                                 <input id="user_id" name='user_id' type="hidden" >
                            </div>
                        </div>
                   <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="lname" class="col-md-4 control-label">Last Name</label>

                            <div class="col-md-6">
                                <input id="lname" type="text" class="form-control" name="lname" value="{{ old('lname') }}" required autofocus>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">Role Name </label>

                            <div class="col-md-6">
                                <select class="form-control" name="role" id="role">
                                   <option value=""> Select Role</option>
                                    @foreach($array_staus as $key => $value)
                                    <option value="{{ $key}}" > {{ $value}}</option>
                                    @endforeach
          
                                </select>
    
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="button" id="update_submit" class="btn btn-primary" >
                                 Update
                                </button>
                            </div>
                        </div>
                    </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  
</div>

@endsection
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
 

<script type="text/javascript">

    $(document).ready(function(){
        //get user data
      $('#main_div').on('click','.record_edit',function(){
        //var id=$(this).attr('data-id');   
          var id=$(this).attr('value');
       $.ajax({
                   url:'{{url("getuser")}}' ,
                   data : {id:id, "_token":"{{ csrf_token() }}"},
                   type: "POST",
                beforeSend: function() {
                        $("#loader-icon").show();
                    },
                success:function(data){
                      var json = $.parseJSON(data);
                      if(json.status){
                        $('#fname').val(json.data['fname']);
                        $('#lname').val(json.data['lname']);
                        $('#email').val(json.data['email']);
                        $('#role').val(json.data['role_id']).attr("selected", "selected");
                       // $('#update_submit').data('uid',json.data['id']); 
                        $('#user_id').val(json.data['id']);
                        
                      }
                    $('#myModal').modal('show');
                },
                complete: function() {
                 $("#loader-icon").hide();  
                },
            });
      });

      //update user data
      $('#main_div').on('click','#update_submit',function(){

          var id= $('#user_id').val();
          var data= $("#form-horizontal").serialize();

       $.ajax({

                   url:'{{url("updateuserdata")}}' ,
                   data :$("#form-horizontal").serialize(),
                   type: "POST",
                beforeSend: function() {
                        $("#loader-icon").show();
                    },
                success:function(data){
                      var json = $.parseJSON(data);
                      if(json.status){
                        alert(data.status);
                          $('.success_div').html('<p class="alert alert-success" id="success"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>Updated Successfully</p>');
                      }
                    $('#myModal').modal('show');
                },
                complete: function() {
                 $("#loader-icon").hide();  
                },
            });
      });


    //Deleted User
      $('.delete_id').on('click',function(){
         var sure = confirm('Are You Sure want to delete This user');
         if(sure)
         {
            var id = $(this).attr('value');
            var url = $('#baseUrl').val();
          
            $('#success').remove();

            $.ajax({
                type :'POST',
                url : url,
                data : {'delete_id':id , '_token':'{{csrf_token()}}'},
                beforeSend: function() {
                        $("#loader-icon").show();
                    },
                    success:function(data){
                      var json = jQuery.parseJSON(data);
                      if(json.status)
                      {
                        //alert(json.status);
                         $('#user_row_'+id).remove();
                         $('.success_div').append('<p class="alert alert-success" id="success"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>Deleted Successfully</p>')
                      }
                    },
                    complete: function() {
                      $("#loader-icon").hide();  
                    },
            });
         }
         else
         {
            alert('Not Deleted User');
         }
      });

    });

</script>
 
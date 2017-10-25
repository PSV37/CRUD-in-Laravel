@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row">
    <div class="col-md-3 ">
            <div class="panel panel-default">
                <div class="panel-heading">Sidebar
              </div>
            <?php if ( Auth::user()->role_id ==1){ ?>
                 <div class="panel-heading"><a href="{{ route('all') }}">Users</a>
              </div> 
            <?php }  ?>     
 
        </div>
     </div>
      
        <div class="col-md-9 ">
            <div class="panel panel-default" style="min-height: 400px;">
                <div class="panel-heading">All Users</div>

         
            </div>
        </div>


    
</div>

@endsection
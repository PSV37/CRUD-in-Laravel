<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class UserController extends Controller
{
    public function index()
    { 
    	$uid = Auth::user()->id;
    	$user_role = User::find($uid)->role;
    	return view('user.index',compact('user_role'));
    }

     public function allusers()
    { 
    	$uid = Auth::user()->id;
    	$arrray_user_data = User::all();
    	return view('user.alluser',compact('arrray_user_data'));
    }

    public function getuser(Request $request)
    { 

    	$id=$request->id;
    	$user_data = User::find($id);
    	$result_array['status']=true;
    	$result_array['data']=$user_data;
    	echo json_encode($result_array);
  
    }


      public function updateuser(Request $request)
    { 
    	$array_data = $request->all();
    	$int_user_id=$array_data['user_id'];
    	$array_user_data['fname']=$array_data['fname'];
    	$array_user_data['lname']=$array_data['lname'];
    	$array_user_data['email']=$array_data['email'];
    	User::where('id', $int_user_id)->update($array_user_data);
    	$result_array['status']=true;
    	echo json_encode($result_array);
  
    }
 
    public function deleteuser(Request $request)
    {
        $int_delete_user = $request->delete_id;
      
        $obj_user_data = User::find($int_delete_user);
        $delete_success = $obj_user_data->delete($int_delete_user);

        if($delete_success)
        {
            $array_response['status'] = true;
        }
        else
        {
            $array_response['status'] = false;
        }

        echo json_encode($array_response);
    }
    
}

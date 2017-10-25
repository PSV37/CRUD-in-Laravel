<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Str;
use Mail;
use Session;
use App\Mail\verifyEmail;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';



    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'role' => 'required',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
       Session::flash('status','Registred But Verify Your Account To Lonig');
        $strt_img_path='images/user.jpg';
       $user =  User::create([
            'fname' => $data['fname'],
            'lname' => $data['lname'],
            'email' => $data['email'],
            'role_id' => $data['role'],
            'user_img' => $strt_img_path,
            'password' => bcrypt($data['password']),
            'verifyToken' =>Str::random(40),
        ]);
          
         $thisuser = User::findOrFail($user->id); 
        $this->sendmail($thisuser);
    }

    public function sendmail($thisuser)
    {
        Mail::to($thisuser['email'])->send(new verifyEmail($thisuser));
    }



    public function verifyEmailFirst()
    {
        return view('email.verifyEmailFirst');
    }


    public function sendEmailDone($email, $verifyToken)
    {
        $user = User::where(['email'=>$email,'verifyToken'=>$verifyToken])->first();
        if($user)
        {
            $user_activation_status = User::where(['email'=>$email,'verifyToken'=>$verifyToken])->update(['status'=>'1','verifyToken'=>NULL]);
            if($user_activation_status)
            {
                return view('email.email_activate');
            }
        }
        else
        {
            return 'User Not Found';
        }
    }
}

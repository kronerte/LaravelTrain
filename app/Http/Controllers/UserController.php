<?php

namespace App\Http\Controllers;
use Mail;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ChangeRequest;

use Illuminate\Support\Facades\Hash;

use App\Users;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getLogin(){
      return view('loginform');
    }

    public function postLogin(LoginRequest $request){
     $user = Users::where('mail','=',$request->input('mail'))
      ->where('confirmation','=',1)
      ->first();
      if ($user){
        
        if (Hash::check($request->input('password'), $user->password)) {
          $request->session()->put('mail',$request->input('mail'));
          $request->session()->put('name',$user->pseudo);
          $request->session()->put('id',$user->id);

         return redirect('');
        }

         return redirect()->route('login');
      }
       return redirect()->route('login');


    }
    public function getRegister(){
      return view('signupform');
    }
    public function postRegister(RegisterRequest $request){
      $users = Users::where('pseudo','=',$request->input('pseudo'))
       ->get();
       if (count($users)==1){
          return redirect()->route('register');
       }
      $users = Users::where('mail','=',$request->input('mail'))
       ->get();
       if (count($users)==1){
          return redirect()->route('register');
       }

        $confirmation_code = str_random(25);
        $user = new Users;
        $user->pseudo = $request->input('pseudo');
        $user->password = Hash::make($request->input('password'));
        $user->mail = $request->input('mail');
        $user->confirmationCode = $confirmation_code;
        $user->save();


        Mail::send('email_confirm', ['pseudo' =>$request->input('pseudo'),'code' => $confirmation_code], function($message)
          {
              $message->to($_POST['mail'])->subject('Register');
          });
      return view('envoiemail');
    }

    public function validation($code){
      $users = Users::where('confirmationCode','=',$code)->get();
      foreach ($users as $user) {
          $user->confirmationCode = null;
          $user->confirmation = 1;
          $user->save();
      }
      return view('comptevalide');
    }

    public function deconnexion(){
       session()->flush();
      return redirect('');
    }

    public function getChange(){
      return view('changeform');
    }
    public function postChange(ChangeRequest $request){
      $user = Users::find(session('id'));
      $user->password = Hash::make($request->input('password'));
      $user->save();
      return redirect('');
    }
}

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
  /**
     * UserController getLogin.
     *Permet d'obtenir le formulaire de connexion
     */
    public function getLogin(){
      return view('loginform');
    }

    /**
       * UserController postLogin.
       *Permet de traiter le formulaire de connexion
       */
    public function postLogin(LoginRequest $request){
      // Je vérifie si il existe un utilisateur avec cette adresse mail
     $user = Users::where('mail','=',$request->input('mail'))
      ->where('confirmation','=',1)
      ->first();
      if ($user){
        //je vérifie si le mot de passe est correct
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
    /**
       * UserController getRegister.
       *Permet d'obtenir le formulaire d'inscription'
       */
    public function getRegister(){
      return view('signupform');
    }

    /**
       * UserController postRegister.
       *Permet de traiter le formulaire d'inscription'
       */
    public function postRegister(RegisterRequest $request){
      //je vérifie si le pseudo est déjà utilisé
      $users = Users::where('pseudo','=',$request->input('pseudo'))
       ->get();
       if (count($users)==1){
          return redirect()->route('register');
       }
         //je vérifie si lemail est déjà utilisé
      $users = Users::where('mail','=',$request->input('mail'))
       ->get();
       if (count($users)==1){
          return redirect()->route('register');
       }
        //enregistrement du nouvel utilisateur
        $confirmation_code = str_random(25);
        $user = new Users;
        $user->pseudo = $request->input('pseudo');
        $user->password = Hash::make($request->input('password'));
        $user->mail = $request->input('mail');
        $user->confirmationCode = $confirmation_code;
        $user->save();

       //envoie du mail de confirmation
        Mail::send('email_confirm', ['pseudo' =>$request->input('pseudo'),'code' => $confirmation_code], function($message)
          {
              $message->to($_POST['mail'])->subject('Register');
          });
      return view('envoiemail');
    }

    /**
       * UserController validation.
       *Permet de traiter la validation du compte
       */
    public function validation($code){
      $users = Users::where('confirmationCode','=',$code)->get();
      foreach ($users as $user) {
          $user->confirmationCode = null;
          $user->confirmation = 1;
          $user->save();
      }
      return view('comptevalide');
    }


    /**
       * UserController deconnexion.
       *Permet de traiter la déconnexion de l'utilisateur
       */
    public function deconnexion(){
       session()->flush();
      return redirect('');
    }

    /**
       * UserController getChange.
       *Permet de trécupérer le formulaire pour changer de mot de passe
       */
    public function getChange(){
      return view('changeform');
    }
    /**
       * UserController getChange.
       *Permet de traiter le formulaire pour changer de mot de passe
       */
    public function postChange(ChangeRequest $request){
      $user = Users::find(session('id'));
      $user->password = Hash::make($request->input('password'));
      $user->save();
      return redirect('');
    }
}

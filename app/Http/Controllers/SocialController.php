<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use Session;
use App\Users;

class SocialController extends Controller
{
  /**
     * SocialController constructor.
     * On autorise la route seulement pour les utilisateurs non connectés
     */
    public function __construct(){
        $this->middleware('guest');
    }

    /**
     * @param $provider
     * @return mixed
     * Fonction qui va se charger de rediriger notre application vers l'url du provider
     */
    public function redirect($provider){
        return Socialite::driver($provider)->redirect();
    }

    /**
     * @param $provider
     * @return mixed
     * @throws \Exception
     * Fonction de callback ou le provider nous redirige en passant l'utilisateur
     */
    public function callback($provider){

        //Récupération de l'utilisateur renvoyé
        try{
            $providerUser = Socialite::driver($provider)->user();
        }catch(\Exception $e){
            throw $e;
        }

        //Ici vous pouvez dd($providedUser) pour voir à quoi ressemble
        //les données renvoyées selon le provider

        //Si j'ai déjà le provider_id dans la base de donnée
        //je connecte directement l'utilisateur
        $user = $this->checkIfProviderIdExists($providerUser->id);

        if($user){
          session(['id' =>  1,'name'=>  'MMM','password'=>  $user->confirmationCode,'confirmation'=>  $user->confirmation,'mail'=> $user->mail]);
            return redirect('/');
        }

        //Je vérifie si j'ai un email
        if($providerUser->email !== null){
            //Je rajoute le provider_id a l'utilisateur dont le mail
            //correspond et je redirige vers la page appelé
            $user = Users::where('mail', $providerUser->email)->first();
            if($user){
                $user->FacebookProvider = $providerUser->id;
                $user->save();
                session(['id' =>  2,'name'=>  'MMM','password'=>  $user->FacebookProvider,'confirmation'=>  $user->confirmation,'mail'=> $user->mail]);
                return redirect('/');
            }
        }

        //Je crée l'utilisateur si j'arrive jusque là ;)
        $user = Users::create([
            'pseudo' => $providerUser->name,
            'mail' => $providerUser->email,
            'FacebookProvider' => $providerUser->id,
            'confirmation' => 1,
        ]);

        if($user){
        session(['id' =>  3,'name'=>  'MMM','password'=>  $user->password,'confirmation'=>  $user->confirmation,'mail'=> $user->mail]);
        }
        return redirect('/');

    }

    /**
     * @param $provider
     * @param $providerId
     * @return mixed
     * Fonction qui vérifie si l'utilisateur à déjà un identifiant
     * venant d'un réseau social
     */
    public function checkIfProviderIdExists($providerId){



        $user = Users::where('FacebookProvider', '=',$providerId)->first();

        return $user;

    }
}

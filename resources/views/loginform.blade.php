@extends('template')

@section('title')
Connexion

@endsection


@section('content')
<div class="panel panel-info">
  <div class="panel-heading">Connexion</div>
    <div class="panel-body">
      <form method='POST' action="{!!route('login')!!}">
        {!! csrf_field() !!}
        <div class="form-group {!! $errors->has('pseudo') ? 'has-error' : '' !!}">
          <input type='text' name='mail'  placeholder='adresse@mail'>
          {!! $errors->first('mail', '<small class="help-block">:message</small>') !!}
        </div>
        <div class="form-group {!! $errors->has('mail') ? 'has-error' : '' !!}">
          <input type='password' name='password'  placeholder='mot de passe'>
          {!! $errors->first('password', '<small class="help-block">:message</small>') !!}
        </div>
        <input type='submit' value='envoyer'>
      </form>
    </div>
  </div>
</div>

<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : 1049860088499928,
      cookie     : true,
      xfbml      : true,
      version    : 1
    });

    FB.AppEvents.logPageView();

  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "https://connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>
<fb:login-button
  scope="public_profile,email"
  onlogin="checkLoginState();">
</fb:login-button>


@endsection

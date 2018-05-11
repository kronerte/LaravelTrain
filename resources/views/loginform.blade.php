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




<a class="button" href="{{url('facebook')}}"><button><i class="fa fa-facebook pr-1"></i> Se Connecter avec Fecebook </button></a>





@endsection

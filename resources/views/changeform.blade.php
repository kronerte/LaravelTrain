@extends('template')

@section('title')
Connexion

@endsection


@section('content')
<div class="panel panel-info">
  <div class="panel-heading">Changer de mot de passe</div>
    <div class="panel-body">
      <form method='POST' action="{!!route('changepswd')!!}">
        {!! csrf_field() !!}
        <div class="form-group {!! $errors->has('password') ? 'has-error' : '' !!}">

          <input type='password' name='password' placeholder='nouveau mot de passe'>
          {!! $errors->first('password', '<small class="help-block">:message</small>') !!}
        </div>
        <div class="form-group {!! $errors->has('password_confirmation') ? 'has-error' : '' !!}">
          <input type='password' name='password_confirmation'  placeholder='confirmation'>
          {!! $errors->first('password_confirmation', '<small class="help-block">:message</small>') !!}
        </div>
        <input type='submit' value='envoyer'>
      </form>
    </div>
  </div>
</div>

@endsection

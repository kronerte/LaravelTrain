@extends('template')

@section('title')
Inscription

@endsection


@section('content')
<div class="panel panel-info">
  <div class="panel-heading">Inscription</div>
    <div class="panel-body">
      <form method='POST' action="{!!route('register')!!}">
        {!! csrf_field() !!}
        <div class="form-group {!! $errors->has('pseudo') ? 'has-error' : '' !!}">
          <input type='text' name='pseudo'  placeholder='pseudo'>
          {!! $errors->first('pseudo', '<small class="help-block">:message</small>') !!}
        </div>
        <div class="form-group {!! $errors->has('mail') ? 'has-error' : '' !!}">
          <input type='text' name='mail'  placeholder='adresse@mail'>
          {!! $errors->first('mail', '<small class="help-block">:message</small>') !!}
        </div>
        <div class="form-group {!! $errors->has('password') ? 'has-error' : '' !!}">
          <input type='password' name='password'  placeholder='mot de passe'>
          {!! $errors->first('password', '<small class="help-block">:message</small>')!!}
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

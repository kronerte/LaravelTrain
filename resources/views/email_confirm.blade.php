<!DOCTYPE html>

<html lang="fr">

  <head>

    <meta charset="utf-8">

  </head>

  <body>

    <h2>{{$pseudo}}! Validez votre compte</h2>

    <a href={{route('valider',['code' => $code])}}> cliquez ici</a>



  </body>

</html>

<?php


// los require los dejo asi ../ , pero se solventa con namespace en las clases a llamar 
// y entonces aca se llaman con sin rutas largas

require_once("../api/Api.php");

require_once("../api/Subscriber.php");



require_once("../Log.php");

//getting request variables
$email  = trim($_POST['email']);
$name   = trim($_POST['name']);
$tyc    = $_POST['tyc'];

// setting local variables
$result;
$res  = array();



/* $estado = "todo ok";
$log = new Log();
$log->newLine($email, $estado); */




$sus = new Subscriber();

$find = $sus->findSubscriber($email);

if ( count($find['entries']) >0 ) { 
  if ( $find['entries'][0]['email'] == $email){
    $subsId = $find['entries'][0]['id']; 
    $result  = $sus->updateSubscriber($email, $name, $subsId);
    $res['status']  = "ok" ; 
    $res['message'] = "Haz actualizado tus datos" ;
  }
}else{
  $result = $sus->addSubscriber($email, $name, $tyc);
  $res['status']  = "ok" ; 
  $res['message'] = "Te haz registrado exitosamente.";  
}//if 
 


  //
  /* $api = new Api();
  $refreshToken= $api->refreshToken(); */
 

echo json_encode($res); 



?>
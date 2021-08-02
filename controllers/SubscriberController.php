<?php


// los require los dejo asi ../ , pero se solventa con namespace en las clases a llamar 
// y entonces aca se llaman con sin rutas largas

require_once("../api/Api.php");

require_once("../api/Subscriber.php");

require_once("../db/db.php");



//getting request variables
$email  = trim($_POST['email']);
$name   = trim($_POST['name']);
$tyc    = $_POST['tyc'];

// setting local variables
$result;




$sus = new Subscriber();

$find = $sus->findSubscriber($email);

if ( count($find['entries']) >0 ) { 
  if ( $find['entries'][0]['email'] == $email){
    $subsId = $find['entries'][0]['id']; 
    $result  = $sus->updateSubscriber($email, $name, $subsId);
  }
}else{
  $result = $sus->addSubscriber($email, $name, $tyc);  
}//if 

print_r($result );   



// ------------------------

/* $db = new db();
$result = $db->insertar("susbscribers", "name, email", " 'miguelito' , 'migule@gmail.com' ");
//$result = $db->seleccionar("susbscribers");

print_r($result); */

// ----------------------------------------------

/* $api = new Api();
$result= $api->refreshToken();


// -----------------------------------------------



/* $log_filename = "log.txt";
if (!file_exists($log_filename)) 
{
  $fp = fopen($log_filename, 'w+');
  fwrite($fp,
  "-----------  Log sistema de subscripcion IwJuan -----------".PHP_EOL);
  fclose($fp);
  chmod($log_filename, 0755); 
}

$estado = "Agregado exitosamente";
// "Fallo envío {$error}" ;
date_default_timezone_set('America/Bogota');
$newLine  = "Correo:".$email.' Fecha:'.date("m/d/yy H:i:s").
" Estado:".$estado.PHP_EOL;

file_put_contents($log_filename , $newLine, FILE_APPEND); 
echo "registro agregado al log \n";  */



 





?>
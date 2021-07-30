<?php

require_once("Subscriber.php");

//$function = $_REQUEST['function'];
$email    = $_POST['email'];
$name     = $_POST['name'];


$sus = new Subscriber();
$result;
$find = $sus->findSubscriber($email);


if ($find['entries'][0]['email'] == $email){
  //$result  = $sus->updateSubscriber($email, $name);
//print_r($update)
}else{
  $result = $sus->addSubscriber($email, $name);  
}//if 

print_r($result );






?>
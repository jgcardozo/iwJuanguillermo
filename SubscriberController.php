<?php

require_once("Subscriber.php");


$email    = trim($_POST['email']);
$name     = trim($_POST['name']);

$sus = new Subscriber();
$result;


$find = $sus->findSubscriber($email);

print_r($find);

if ( count($find['entries']) >0 ) { 
  if ( $find['entries'][0]['email'] == $email){
    $subsId = $find['entries'][0]['id']; 
    $result  = $sus->updateSubscriber($email, $name, $subsId);
  }
}else{
  $result = $sus->addSubscriber($email, $name);  
}//if 

print_r($result );






?>
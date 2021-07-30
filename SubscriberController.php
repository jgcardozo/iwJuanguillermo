<?php

require_once("Subscriber.php");


$email    = $_POST['email'];
$name     = $_POST['name'];

$sus = new Subscriber();
$result;


$find = $sus->findSubscriber($email);
$subsId = $find['entries'][0]['id']; 



if ($find['entries'][0]['email'] == $email){
  $result  = $sus->updateSubscriber($email, $name, $subsId);
}else{
  $result = $sus->addSubscriber($email, $name);  
}//if 

print_r($result );






?>
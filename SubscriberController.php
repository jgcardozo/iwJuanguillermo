<?php

require_once("Subscriber.php");

//$function = $_REQUEST['function'];
$email    = $_POST['email'];
$name     = $_POST['name'];


/* switch ($function)
{
    case 'existingSubscriber': existingSubscriber($email);
        break;
    case 'addSubscriber': addSubscriber($email, $name);
      break;
    case 'updateSubscriber': updateSubscriber($email, $name);
      break;
    
  } //sw */



$sus = new Subscriber();

$find = $sus->findSubscriber($email);

print_r($find);



echo "fin";

/* foreach ($find as $item) {
  # code...
} */

//$add  = $sus->addSubscriber($email, $name);

//echo $add;


?>
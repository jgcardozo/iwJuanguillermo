<?php

require_once("Account.php");



  class Lista{  //hice esto aproposito para mostrar que se debe tener cuidado con palabras reservadas como List en este caso


   
    public $url;
   
    public function getListId($url){

        $accessToken = Account::$accessToken;

        $headers = [
            'User-Agent' => 'AWeber-PHP-code-sample/1.0',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $accessToken
        ];
        $url = "https://api.aweber.com/1.0/accounts/".Account::$accountId."/lists";
        $response = Account::Cliente()->get($url, ['headers' => $headers]);
        $body = json_decode($response->getBody(), true);
     
        return $body;
    
   

   } //funct getListId

 }//class 




?>
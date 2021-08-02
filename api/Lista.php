<?php

require_once("Api.php");

require_once("Account.php");

  class Lista{ 

 
    private $headers;

    public function __construct()
    {
        $this->cuenta     = new Account();
        $this->urlAccount = 'https://api.aweber.com/1.0/accounts';
        $this->account    = $this->cuenta->getAccountData($this->urlAccount); 

        $api = new Api();
        $this->headers = $api->headers;            
    } //construct

   
    public function getList() 
    {
        $this->url = "https://api.aweber.com/1.0/accounts/".Account::$accountId."/lists";
        $response = Api::conexion()->get($this->url, ['headers' => $this->headers]);
        $body = json_decode($response->getBody(), true);
        return $body;
    } //funct getListId




 // creo que custom fields puede ir aca, porque tiene relacion o depende de la lista 
 // aunque para un desarrollo que no sea un test , por desacoplamiento y mas razones puede ser una class aparte
 // lo mismo getTags, pero por ser test asi puede ser y no es mala practica
    public function getCustomFields()
    {
        $listInfo  = self::getList(); 
        $url = $listInfo['entries'][0]['custom_fields_collection_link']; 
 
        $response = Api::conexion()->get($url, ['headers' => $this->headers]);
        $body = json_decode($response->getBody(), true);
        return $body;        
    } //  getCustomFields


 }//class 




?>
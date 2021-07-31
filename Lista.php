<?php

require_once("Account.php");



  class Lista{  //hice esto aproposito para mostrar que se debe tener cuidado con palabras reservadas como List en este caso


   
    public $url;
    private $accessToken, $headers;


    public function __construct(){
        $this->accessToken = Account::$accessToken;
        $this->headers = [
            'User-Agent' => 'AWeber-PHP-code-sample/1.0',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->accessToken
        ];
    }

   
    public function getListId($url)
    {
        $url = "https://api.aweber.com/1.0/accounts/".Account::$accountId."/lists";
        $response = Account::Cliente()->get($url, ['headers' => $this->headers]);
        $body = json_decode($response->getBody(), true);
     
        return $body;
    } //funct getListId



/*    public function getTags(){

    self::getListId()

    //$tagUrl = $lists[0]['self_link'] . '/tags';

   } // getTags
 */


 }//class 




?>
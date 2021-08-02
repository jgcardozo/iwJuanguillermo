<?php

    require '../vendor/autoload.php';

    require_once("Api.php");

  

    
    class Account{
  
        
        public static  $accountId;
        private $accessToken;
      

        public function __construct()
        {
            $api = new Api();
            $this->accessToken = $api->accessToken;   
        } //construct


        public function getAccountData($url) { 
                     
       
            $collection = array();
            while (isset($url)) {
               
                $request = Api::conexion()->get($url,
                    ['headers' => ['Authorization' => 'Bearer ' . $this->accessToken]]
                );
             
                $body = $request->getBody();
                $page = json_decode($body, true);
                $collection = array_merge($page['entries'], $collection);
                $url = isset($page['next_collection_link']) ? $page['next_collection_link'] : null;
            }
            self::$accountId = $collection[0]['id'];
            return $collection;
        } // getAccountData

  


    } //class
?>
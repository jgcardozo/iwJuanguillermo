<?php

    require 'vendor/autoload.php';

    require_once("Api.php");

  

    
    class Account{
  
        
        public static  $accountId;

        public $url;


        public function getAccountData($url) { 
                     
            $api = new Api();
            $accessToken = $api->accessToken;         
          
            $collection = array();
            while (isset($url)) {
                $request = Api::conexion()->get($url,
                    ['headers' => ['Authorization' => 'Bearer ' . $accessToken]]
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
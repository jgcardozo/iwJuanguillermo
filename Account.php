<?php

    require 'vendor/autoload.php';

    use GuzzleHttp\Client;
    
    class Account{

       
        
        private $client;

        private $credentials; 

        public static $accessToken, $accountId;

        public $url;



        public static function Cliente(){
            $cliente = new GuzzleHttp\Client();
            return $cliente;
        }//client
  
 
        public function getAccountData($url) { 

            $this->client = new GuzzleHttp\Client();
            $this->credentials = parse_ini_file('credentials.ini');
            self::$accessToken = $this->credentials['accessToken'];
          

            $collection = array();
            while (isset($url)) {
                $request = self::Cliente()->get($url,
                    ['headers' => ['Authorization' => 'Bearer ' . self::$accessToken]]
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
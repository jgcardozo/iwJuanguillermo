<?php

    require 'vendor/autoload.php';


    //require_once("aweber.php");

    use GuzzleHttp\Client;



    
    class Account{
  
        
        private $client;

        private $credentials; 

        public static $accessToken, $accountId;

        public $url;


/*         const TOKEN_URL = 'https://auth.aweber.com/oauth2/token';

        public function __construct()
        {//juan aca voy hacer el refresh toke, para cada peticion
            $credentials = parse_ini_file('credentials.ini', true);
            $client = new GuzzleHttp\Client();
            $clientId = $credentials['clientId'];
            $clientSecret = $credentials['clientSecret'];
            $response = $client->post(
                TOKEN_URL, [
                    'auth' => [
                        $clientId, $clientSecret
                    ],
                    'json' => [
                        'grant_type' => 'refresh_token',
                        'refresh_token' => $credentials['refreshToken']
                    ]
                ]
            );
            $body = $response->getBody();
            $newCreds = json_decode($body, true);
            $accessToken = $newCreds['access_token'];
            $refreshToken = $newCreds['refresh_token'];

        }//construct */


        public static function Cliente(){
            try {
                $cliente = new GuzzleHttp\Client();
                return $cliente;
            } catch (\Throwable $e) {
                //mandar a log $e->getMessage();
                echo "Error controlado: Favor refrescar Token";
            }
           
        }//client
  
 
        public function getAccountData($url) { 

            try {
                $this->client = new GuzzleHttp\Client();
            } catch (\Throwable $e) {
                //mandar a log $e->getMessage();
                echo "Error controlado: Favor refrescar Token";
            }

           
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
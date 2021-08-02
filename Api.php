<?php


require 'vendor/autoload.php';

const TOKEN_URL = 'https://auth.aweber.com/oauth2/token';



class Api{

    private $conexion, $credentials; 
    private $clientId, $clientSecret, $refreshToken;
 
    public $accessToken;


     public function __construct()
    {    
        $this->credentials = parse_ini_file('credentials.ini', true);
        $this->accessToken = $this->credentials['accessToken'];
    }//construct() 

    public static function conexion(){
        try {
            $conexion = new GuzzleHttp\Client();
            return $conexion;
        } catch (\Throwable $e) {
            //mandar a log $e->getMessage();
            echo "Error controlado: Favor refrescar Token";
        }
       
    }//conexion


    public function refreshToken()
    {
       
        if(sizeof($this->credentials) == 0 ||
           !array_key_exists('clientId', $this->credentials) ||
           !array_key_exists('clientSecret', $this->credentials) ||
           !array_key_exists('accessToken', $this->credentials) ||
           !array_key_exists('refreshToken', $this->credentials)) {
            return "No credentials.ini exists, or file is improperly formatted.\n";
        }
        $client = new GuzzleHttp\Client();
        $this->clientId     = $this->credentials['clientId'];
        $this->clientSecret = $this->credentials['clientSecret'];
        $response = $client->post(
            TOKEN_URL, [
                'auth' => [
                    $this->clientId, $this->clientSecret
                ],
                'json' => [
                    'grant_type' => 'refresh_token',
                    'refresh_token' => $this->credentials['refreshToken']
                ]
            ]
        );
        $body = $response->getBody();
        $newCreds = json_decode($body, true);
        $this->accessToken = $newCreds['access_token'];
        $this->refreshToken = $newCreds['refresh_token'];

        $update =$this->updateFile();

        return $update;

    } //refreshToken


    private function updateFile(){
        $fp = fopen('credentials.ini', 'w+'); 
        fwrite($fp,
        "clientId    = {$this->clientId}
        clientSecret = {$this->clientSecret}
        accessToken  = {$this->accessToken}
        refreshToken = {$this->refreshToken}");
        fclose($fp);
        //chmod('credentials.ini', 0755);  
        return "accessToken y refreshToken actualizados"; 
    } //updateFile



} //class









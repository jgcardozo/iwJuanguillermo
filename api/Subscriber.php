<?php

require_once("Api.php");

require_once("Account.php");

require_once("Lista.php");

require_once("../db/db.php");


class Subscriber{

  private $cuenta    ;
  private $urlAccount;
  private $account   ;
 
  private $lista    ;
  private $listInfo ;
  private $urlLista ;

  private $urlSubscribers;
  private $headers;
  
   

  public function __construct()
  {
    $this->cuenta     = new Account();
    $this->urlAccount = 'https://api.aweber.com/1.0/accounts';
    $this->account    = $this->cuenta->getAccountData($this->urlAccount); 
    $this->urlLista   = $this->account[0]['lists_collection_link'];
  
    $this->lista     = new Lista();
    $this->listInfo  = $this->lista->getList();  //$this->urlLista
    $this->listInfo  = $this->listInfo['entries'][0];
    $this->urlLista  = $this->listInfo['self_link'];
     
    $this->urlSubscribers = $this->urlLista."/subscribers";
    $api = new Api();
    $this->headers = $api->headers;

  } //construct



  public function findSubscriber($email)
  {
      $url = $this->urlSubscribers;
      $params = [
          'ws.op' => 'find',
          'email' => $email,
      ];
      $findUrl = $url . '?' . http_build_query($params);
      $response = Api::conexion()->get($findUrl, ['headers' => $this->headers]);
      $body = json_decode($response->getBody(), true);
      //$this->statusCode = $response->getStatusCode(); 
      //$response->getReasonPhrase();
      return $body;
  } //findSubscriber



  public function addSubscriber($email, $name, $tyc)
  {

      $body = [
        'email' => $email,
        'name'  => $name,
        'ip_address' => '190.90.155.129', //$this->ipUser,
        'tags' => [
            'test_new_sub',
          ],         
      ];

      $campos  = "name, email";
      $valores = " '$name' , '$email' ";


      // esto se puede mejorar con un private static, y llamarlo con self:: 
      // ,pero lo dejare asi . pq ya mostre en account.class que lo se hacer 
      // aca no caigo pej en dont repeat yourself o boilerPlate     
      if ($tyc=="true"){
        //url
        $http = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";  
        $user_url = $http.$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        //ip
        $user_ip = $_SERVER['REMOTE_ADDR'];
        // fecha y hora
        date_default_timezone_set('America/Bogota');
        $user_fecha = date('Y-m-d');
        $user_hora  = date('H:i'); 

        // get customFiels for fill it
        $lista =  new Lista();
        $cFields = $lista->getCustomFields();
        $entries = $cFields['entries']; 


        foreach ($entries as $item) {
          $body['custom_fields'][$item['name']]     = ${'user_'.$item['name']};
 /*          $campos  .= ",".$item['name'];
          $valores .= " , '".${'user_'.$item['name']}."' "; */
        } // for 

        

      }//if tyc
    
  
      $url = $this->urlSubscribers; 
      $response = Api::conexion()->post($url, ['json' => $body, 'headers' => $this->headers]);
      $data = $response->getHeader('Location')[0];

      // segun entendi solo es para los nuevos usuarios
      $db = new db();
      $result = $db->insertar("susbscribers", $campos, $valores); 
    
      return $data;

    } // addSubscriber





    public function updateSubscriber($email, $name, $subsId) 
    {
      // harcodee el tag, en este caso no creo necesario traerlos del endpoint,
      // como si es el caso del los customFields con getCustomFields() 
      $body = [
        'email' => $email,
        'name'  => $name,
        'tags' => [
          'add' => [
            'test_existing_sub'
          ],
          'remove' => [
            'test_new_sub'
          ]
        ]
      ];
      $url = $this->urlSubscribers   .'/'.$subsId;
      $response = Api::conexion()->patch($url, ['json' => $body, 'headers' => $this->headers]);
      $body = json_decode($response->getbody(), true);
      return $body;
    } //updateSubscriber()




}//class

 
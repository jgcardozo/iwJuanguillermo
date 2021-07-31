<?php

require_once("Account.php");

require_once("Lista.php");


class Subscriber{

  private $cuenta    ;
  private $urlAccount;
  private $account   ;
 
  private $lista    ;
  private $listInfo ;
  private $urlLista ;

  private $urlSubscribers;
  private $ipUser;
  private $headers;
  
  public $statusCode;
   

  public function __construct()
  {
    $this->cuenta     = new Account();
    $this->urlAccount = 'https://api.aweber.com/1.0/accounts';
    $this->account    = $this->cuenta->getAccountData($this->urlAccount) ; 
    $this->urlLista   = $this->account[0]['lists_collection_link'];
  
   
    $this->lista     = new Lista();
    $this->listInfo  = $this->lista->getListId($this->urlLista); 
    $this->listInfo  = $this->listInfo['entries'][0];
    $this->urlLista  = $this->listInfo['self_link'];
     
    $this->urlSubscribers = $this->urlLista."/subscribers";
    $this->headers = [
      'Content-Type' => 'application/json',
      'Accept' => 'application/json',
      'User-Agent' => 'AWeber-PHP-code-sample/1.0',
      'Authorization' => 'Bearer ' . Account::$accessToken,
    ];
    $this->ipUser = $_SERVER['REMOTE_ADDR'];  
  } //construct



  public function findSubscriber($email)
  {
      $url = $this->urlSubscribers;
      $params = [
          'ws.op' => 'find',
          'email' => $email,
      ];
      $findUrl = $url . '?' . http_build_query($params);
      $response = Account::Cliente()->get($findUrl, ['headers' => $this->headers]);
      $body = json_decode($response->getBody(), true);
      $this->statusCode = $response->getStatusCode(); 
      //$response->getReasonPhrase();
      return $body;
  } //findSubscriber



  public function addSubscriber($email, $name)
  {

  $body = [

        'email' => $email,
        'name'  => $name,
        'ip_address' => '190.90.155.129', //$this->ipUser,
        'tags' => [
            'test_new_sub',
          ],
   
              /*     'ad_tracking' => 'ebook',
        'custom_fields' => [
          'apple' => 'fuji',
          'pear' => 'bosc'
        ], */
      ];

      $url = $this->urlSubscribers; 
      $response = Account::Cliente()->post($url, ['json' => $body, 'headers' => $this->headers]);
      $data = $response->getHeader('Location')[0];
    
      return $data;

    } // addSubscriber





    public function updateSubscriber($email, $name, $subsId) 
    {
      // $tag; para no harcodear
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
                 /*,
        'custom_fields' => [
          'apple' => 'fuji',
          'pear' => 'bosc'
        ], */ 
      ];
      $url = $this->urlSubscribers   .'/'.$subsId;
      $response = Account::Cliente()->patch($url, ['json' => $body, 'headers' => $this->headers]);
      $body = json_decode($response->getbody(), true);
      return $body;
    } //updateSubscriber()




}//class

 
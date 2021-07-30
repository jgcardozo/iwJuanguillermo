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
    $this->ipUser = $_SERVER['REMOTE_ADDR'];  
  } //construct



  public function findSubscriber($email)
  {

    $headers = [
      'User-Agent' => 'AWeber-PHP-code-sample/1.0',
      'Accept' => 'application/json',
      'Authorization' => 'Bearer ' . Account::$accessToken,
  ];
  $url = $this->urlSubscribers;
  $params = [
      'ws.op' => 'find',
      'ad_tracking' => 'ebook',
/*       'area_code' => 555,
      'city' => 'Chalfont',
      'country' => 'United States',
      'custom_fields' => json_encode(['apple' => 'fuji', 'pear' => 'bosc']),
      'dma_code' => 504, */
      'email' => $email,
      /* 'last_followup_message_number_sent' => 0,
      'last_followup_message_sent_at' => '2017-11-28',
      'latitude' => 37.751,
      'longitude' => -97.822,
      'misc_notes' => 'ebook',
      'name' => 'John Doe',
      'postal_code' => '99999-9999',
      'region' => 'PA',
      'status' => 'unconfirmed',
      'subscribed_at' => '2017-07-16',
      'subscription_method' => 'api',
      'tags' => json_encode(['fast']),
      'tags_not_in' => json_encode(['slow']),
      'unsubscribe_method' => 'api: move',
      'unsubscribed_at' => '2017-10-13',
      'verified_at' => '2017-07-18' */
  ];
  $findUrl = $url . '?' . http_build_query($params);
  $response = Account::Cliente()->get($findUrl, ['headers' => $headers]);
  $body = json_decode($response->getBody(), true);
  return $body;

  } //findSubscriber



  public function addSubscriber($email, $name)
  {

  $body = [
    /*     'ad_tracking' => 'ebook',
        'custom_fields' => [
          'apple' => 'fuji',
          'pear' => 'bosc'
        ], */
        'email' => $email,
        'name'  => $name,
        'ip_address' => '190.90.155.129', //$this->ipUser,
        'last_followup_message_number_sent' => 0,
        'misc_notes' => 'string',
        'strict_custom_fields' => true,
    /*     'tags' => [
          'slow',
          'fast',
          'lightspeed'
        ] */
      ];

      $headers = [
          'Content-Type' => 'application/json',
          'Accept' => 'application/json',
          'User-Agent' => 'AWeber-PHP-code-sample/1.0',
          'Authorization' => 'Bearer ' . Account::$accessToken,
      ];

      $url = $this->urlSubscribers;
      
      $response = Account::Cliente()->post($url, ['json' => $body, 'headers' => $headers]);
      $data = $response->getHeader('Location')[0];
    
      return $data;

    } // addSubscriber



/*         try { 
            $accounts =  $cuenta->getAccountData($url) ; 
            $res['status']  = count($accounts)>0 ? 'ok': 'error' ;
            $res['message'] = count($accounts)>0 ? 'everything went well': 'check your endPoint url' ;
        } catch (\Throwable $error) {
            $res['status']  = 'Controlled exception';
            $res['message'] =  $error->getMessage() ;
        }//try */



}//class

 
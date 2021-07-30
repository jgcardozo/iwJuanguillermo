<?php

/*
    $clientId                = 'jAbFHEEpox3a3O6eYWsNcDrpK86blssW';    
    $clientSecret            = 'COIvsBWq2xWeT8P5Fj44P1xFhm45M2YX';  
*/
 
require 'vendor/autoload.php';
use League\Oauth2\Client\Provider\GenericProvider;
  

const OAUTH_URL = 'https://auth.aweber.com/oauth2/';
const TOKEN_URL = 'https://auth.aweber.com/oauth2/token';


echo 'Do you wish to create(c) tokens or refresh(r) tokens? ';
$createRefresh = rtrim(fgets(STDIN), PHP_EOL);

if (strtoupper($createRefresh) == 'C') {
    echo 'Enter your client id: ';
    $clientId = rtrim(fgets(STDIN), PHP_EOL);
    echo 'Enter your client secret: ';
    $clientSecret = rtrim(fgets(STDIN), PHP_EOL);

    $redirectUri = 'https://www.aweber.com/users/leads'; //'https://localhost';

    $scopes = array(
        'account.read',
        'list.read',
        'list.write',
        'subscriber.read',
        'subscriber.write',
        'email.read',
        'email.write',
        'subscriber.read-extended',
        'landing-page.read'
    );

    // Create a OAuth2 client configured to use OAuth for authentication
    $provider = new \League\OAuth2\Client\Provider\GenericProvider([
        'clientId' => $clientId,
        'clientSecret' => $clientSecret,
        'redirectUri' => $redirectUri,
        'scopes' => $scopes,
        'scopeSeparator' => ' ',
        'urlAuthorize' => OAUTH_URL . 'authorize',
        'urlAccessToken' => OAUTH_URL . 'token',
        'urlResourceOwnerDetails' => 'https://api.aweber.com/1.0/accounts'
    ]);

    $authorizationUrl = $provider->getAuthorizationUrl();

    $_SESSION['oauth2state'] = $provider->getState();

    echo "Go to this url: " . $authorizationUrl . "\n";
    echo "Log in and paste the returned URL here: ";
    $authorizationResponse = rtrim(fgets(STDIN), PHP_EOL);
    $parsedUrl = parse_url($authorizationResponse, PHP_URL_QUERY);
    parse_str($parsedUrl, $parsedArray);
    $code = $parsedArray['code'];

    $token = $provider->getAccessToken('authorization_code', [
        'code' => $code
    ]);

    $accessToken = $token->getToken();
    $refreshToken = $token->getRefreshToken();
}
elseif(strtoupper($createRefresh) == 'R') {
    $credentials = parse_ini_file('credentials.ini', true);
    if(sizeof($credentials) == 0 ||
       !array_key_exists('clientId', $credentials) ||
       !array_key_exists('clientSecret', $credentials) ||
       !array_key_exists('accessToken', $credentials) ||
       !array_key_exists('refreshToken', $credentials)) {
        echo "No credentials.ini exists, or file is improperly formatted.\n";
        echo "Please create new credentials.";
        exit();
    }
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
}
else {
    echo 'Invalid entry. You must enter "c" or "r".';
    exit();
}

$fp = fopen('credentials.ini', 'w+'); //'wt'
fwrite($fp,
"clientId = {$clientId}
clientSecret = {$clientSecret}
accessToken = {$accessToken}
refreshToken = {$refreshToken}");
fclose($fp);
chmod('credentials.ini', 0755);   //600
echo "Updated credentials.ini with your new credentials\n";






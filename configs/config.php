<?php
require_once 'vendor/autoload.php';

// init configuration
$clientID = '1042224953790-6pclfk6bg2jtjhc1hjhsiedj8dsmuj5d.apps.googleusercontent.com';
$clientSecret = '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';
$redirectUri = 'http://localhost/webmobile/signin/login';

// create Client Request to access Google API
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");

<?php

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require $_SERVER['DOCUMENT_ROOT'] . '/lib/config.php';

/**
 * checks the POST variables and provides validation messages
 */
function validateCharge() {
    $errors = [];
    if(!isset($_POST['token']) || !$_POST['token']) {
        // token empty
        $errors["token"] = "The token field is required.";
    }
    if(!isset($_POST['amountInCents']) || !$_POST['amountInCents']) {
        // amount in cents empty
        $errors["amountInCents"] = "The amount in cents field is required.";
    } elseif(!is_numeric($_POST['amountInCents']) || (int)($_POST['amountInCents']) != $_POST['amountInCents']) {
        // amount in cents not a number
        $errors["amountInCents"] = "The amount in cents must be an integer";
    }
    if(!isset($_POST['currency']) || !$_POST['currency']) {
        // token empty
        $errors["currency"] = "The currency field is required.";
    }
    if($errors) {
        return $errors;
    }
}

if ($errors = validateCharge()) {
    Header("HTTP/1.1 422 Unprocessable Entity");
    print(json_encode(['messsage' => "The given data was invalid.", 'errors' => $errors]));
    exit;
}

$token = $_POST['token'];
$amountInCents = $_POST['amountInCents'];
$currency = $_POST['currency'];
$metadata = $_POST['metadata'] ?? [];

$client = new \Yoco\YocoClient($config['secret_key'], $config['public_key']);

// note the keys in use
$env = $client->keyEnvironment();
error_log("Using $env keys for payment");

// process the payment
try {
    print(json_encode($client->charge($token, $amountInCents, $currency, $metadata)));
} catch (\Yoco\Exceptions\ApiKeyException $e) {
    error_log("Failed to charge card with token $token, amount $currency $amountInCents : " . $e->getMessage());
    Header("HTTP/1.1 400 Bad Request");
    print(json_encode(['charge_error' => $e]));
    exit;    
} catch (\Yoco\Exceptions\DeclinedException $e) {
    error_log("Failed to charge card with token $token, amount $currency $amountInCents : " . $e->getMessage());
    Header("HTTP/1.1 400 Bad Request");
    print(json_encode(['charge_error' => $e]));
    exit;
} catch (\Yoco\Exceptions\InternalException $e) {
    error_log("Failed to charge card with token $token, amount $currency $amountInCents : " . $e->getMessage());
    Header("HTTP/1.1 400 Bad Request");
    print(json_encode(['charge_error' => $e]));
    exit;
}

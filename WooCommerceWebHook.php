<?php
$secret = "secretCode"; //WooCommerce Request secret
$request_body = file_get_contents('php://input');
$headers = apache_request_headers();
$webhookSignature = null;

foreach ($headers as $header => $value) {
    switch ($header) {
        case "X-Wc-Webhook-Signature":
            $webhookSignature = $value;
            echo "$header: $value <br />\n";
            break;
    }
}

//Generate signature hash from request body and compare with delivered signature
$hashSignature = base64_encode(hash_hmac('sha256', $request_body, $secret, true));
echo "Signature webhook: $webhookSignature<br>Signature requestHash: $hashSignature<br>";
if ($webhookSignature != $hashSignature) {
    // Invalid webhook signature, ignore the request.
    die();
}

//Now do some great stuff with your order data...
?>
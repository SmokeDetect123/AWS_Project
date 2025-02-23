<?php
if (isset($_GET['user'])) {
    $username = $_GET['user'];
} elseif (isset($_POST['user'])) {
    $username = $_POST['user'];
} else {
    die("User not specified");
}

// Define XML file for each user
$xmlFile = "chat_{$username}.xml";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle message saving
    $message = $_POST['message'];
    $timestamp = date("Y-m-d H:i:s");

    $xml = new DOMDocument();
    $xml->preserveWhiteSpace = false;
    $xml->formatOutput = true;

    if (file_exists($xmlFile)) {
        $xml->load($xmlFile);
    } else {
        $root = $xml->createElement('chat');
        $xml->appendChild($root);
    }

    $messageElement = $xml->createElement('message');
    $userElement = $xml->createElement('user', $username);
    $textElement = $xml->createElement('text', $message);
    $timestampElement = $xml->createElement('timestamp', $timestamp);

    $messageElement->appendChild($userElement);
    $messageElement->appendChild($textElement);
    $messageElement->appendChild($timestampElement);

    $xml->documentElement->appendChild($messageElement);
    $xml->save($xmlFile);

    echo "Message saved successfully";

} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Handle message retrieval
    if (file_exists($xmlFile)) {
        header('Content-Type: application/xml');
        readfile($xmlFile);
    } else {
        echo '<?xml version="1.0"?><chat></chat>';
    }
}
?>

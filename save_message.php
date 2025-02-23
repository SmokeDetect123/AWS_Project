<?php
// save_message.php

// Get the message text and sender from the POST request
$messageText = $_POST['message'] ?? '';
$sender = $_POST['friend'] ?? 'friend1'; // Sender can be 'friend1' or 'friend2'

// Define the XML file based on the sender
$xmlFile = "{$sender}_chat_log.xml";

if ($messageText) {
    if (file_exists($xmlFile)) {
        $xml = simplexml_load_file($xmlFile);
    } else {
        $xml = new SimpleXMLElement('<chatLog></chatLog>');
    }

    // Add a new message entry
    $message = $xml->addChild('message');
    $message->addChild('text', htmlspecialchars($messageText));
    $message->addChild('sender', $sender);
    $message->addChild('timestamp', date('Y-m-d H:i:s'));

    $xml->asXML($xmlFile);
}
?>

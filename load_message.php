<?php
// load_message.php

$friend1File = 'friend1_chat_log.xml';
$friend2File = 'friend2_chat_log.xml';

// Initialize an empty array to store all messages
$messages = [];

// Load messages from Friend 1's XML file
if (file_exists($friend1File)) {
    $xml1 = simplexml_load_file($friend1File);
    foreach ($xml1->message as $message) {
        $messages[] = [
            'text' => (string) $message->text,
            'sender' => (string) $message->sender,
            'timestamp' => (string) $message->timestamp
        ];
    }
}

// Load messages from Friend 2's XML file
if (file_exists($friend2File)) {
    $xml2 = simplexml_load_file($friend2File);
    foreach ($xml2->message as $message) {
        $messages[] = [
            'text' => (string) $message->text,
            'sender' => (string) $message->sender,
            'timestamp' => (string) $message->timestamp
        ];
    }
}

// Sort all messages by timestamp to display them in order
usort($messages, function($a, $b) {
    return strtotime($a['timestamp']) - strtotime($b['timestamp']);
});

// Output messages as HTML
foreach ($messages as $message) {
    $chatClass = ($message['sender'] === 'friend1') ? 'user' : 'friend';

    echo '<div class="chat ' . $chatClass . '">';
    echo '<div class="chat-message">' . htmlspecialchars($message['text']) . '</div>';
    echo '<span class="timestamp">' . htmlspecialchars($message['timestamp']) . '</span>';
    echo '</div>';
}
?>

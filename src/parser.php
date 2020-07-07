<?php

// Parse incoming updates

$update = json_decode(file_get_contents("php://input"));

$chat_id = $update->message->chat->id;
$type = $update->message->chat->type;
$message_id = $update->message->message_id;
$text = $update->message->text;

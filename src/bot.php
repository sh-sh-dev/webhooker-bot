<?php
include "config.php";
include "vendor/telegram.php";
include "parser.php";

global $chat_id, $type, $message_id, $text, $name, $user_name, $user_id;

if (in_array(strtolower($text), ["/start", "/help"])) {
    $example = "143715927:AAMVKs3jlBEqhgdX_8ow_2P2c85FiZTuYjG\nhttps://domain.tld/path/to/bot";
    $welcome = "I can help you to set your bot webhook in Telegram.\nJust send your *Token* and *URL* in separated lines.";

    bot("sendMessage", [
        "chat_id" => $chat_id,
        "text" => $welcome . "\n\nExample:`$example`",
        "reply_to_message_id" => $message_id,
        "parse_mode" => "Markdown"
    ]);
}
else {
    $explode = explode(PHP_EOL, $text);

    $user_token = $explode[0];
    $user_url = $explode[1];

    $set_webhook = bot("setWebhook", [
        "url" => $user_url
    ], false, $user_token, true);

    if (@$set_webhook->ok) {
        $user_bot = bot("getMe", null, null, $user_token, true)->result->username;

        bot("sendMessage", [
            "chat_id" => $chat_id,
            "text" => "@$user_bot has been changed.",
            "reply_to_message_id" => $message_id
        ]);
    }
    else bot("sendMessage", [
        "chat_id" => $chat_id,
        "text" => "something is wrong.",
        "reply_to_message_id" => $message_id
    ]);
}

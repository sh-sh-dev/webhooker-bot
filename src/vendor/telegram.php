<?php

/**
 * Make request to Telegram API
 *
 * @param string $method
 * @param null|array $data
 * @param null|string $token
 * @param bool $die
 * @param bool $return
 *
 * @return bool|object|string
 */
function bot($method, $data = null, $die = false, $token = null, $return = false) {
    if (is_null($token))
        global $token;

    $url = "https://api.telegram.org/bot$token/$method";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, $return);
    if (!empty($data))
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

    $result = curl_exec($ch);

    if ($die)
        die();

    if (curl_error($ch))
        return curl_error($ch);
    else
        return $return ? json_decode($result) : true;
}

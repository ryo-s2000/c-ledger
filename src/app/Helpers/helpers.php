<?php

if (!function_exists('lineNotify')) {
    function lineNotify($message): void
    {
        $lineUrl = 'https://notify-api.line.me/api/notify';
        $token = config('line_notify.token.all');

        exec("curl -X POST -H 'Authorization: Bearer ".$token."' -F 'message=".$message."' ".$lineUrl);
    }
}

if (!function_exists('GoogleChatNotify')) {
    function GoogleChatNotify($message, $constructionNumber): void
    {
        $url = '';

        switch(mb_substr($constructionNumber, 0, 2)){
            case 'KA':
            case 'KB':
            case 'MA':
            case 'MB':
            case 'KD':
                $url = config('google_chat_notify.webhook_url.civil');
                break;
            case 'KC':
            case 'MC':
            case 'MT':
            case 'ZA':
                $url = config('google_chat_notify.webhook_url.architecture');
                break;
            case 'MI':
                $url = config('google_chat_notify.webhook_url.house');
                break;
        }

        exec("curl -X POST --data "."'".'{"text": "'.$message.'"}'."'"." -H 'Content-Type: application/json' "."'".$url."'");
    }
}

if (!function_exists('warekiToAd')) {
    function warekiToAd($wareki): int
    {
        // 本当は平成10とかも一致させたい
        $warekis = ['S' => 1925, 'H' => 1988, 'R' => 2018];
        preg_match('!^('. implode('|', array_keys($warekis)) .')([0-9]+)$!', $wareki, $matches);

        if(!$matches) {
            // 本当はH100とかも防ぎたい
            throw new Exception('Invalid wareki');
        }

        $year = intval($matches[2]) + $warekis[$matches[1]];
        return $year;
    }
}

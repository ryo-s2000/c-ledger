<?php

if (!function_exists('lineNotify')) {
    function lineNotify($message): void
    {
        $lineUrl = 'https://notify-api.line.me/api/notify';
        $token = config('line_notify.token.all');

        exec("curl -X POST -H 'Authorization: Bearer ".$token."' -F 'message=".$message."' ".$lineUrl);
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

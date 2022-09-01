<?php

if (!function_exists('lineNotify')) {
    function lineNotify($message): void
    {
        $lineUrl = 'https://notify-api.line.me/api/notify';
        $token = config('line_notify.token.all');

        exec("curl -X POST -H 'Authorization: Bearer ".$token."' -F 'message=".$message."' ".$lineUrl);
    }
}

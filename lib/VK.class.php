<?php
/*
 * @ muxui.cc
 */
class VK {
    private static string $access_token;
    private static float $v;

    public static function setup(string $access_token, float $v = 5.101) : void {
        self::$access_token = $access_token;
        self::$v = $v;
    }

    public static function sendMessage(array $array) : array {
        return self::API('messages.send', array_merge($array, ['random_id' => rand(0, 9999999999)]));
    }

    public static function API(string $method, array $array) : array {
        $array['access_token'] = self::$access_token;
        $array['v'] = self::$v;

        return json_decode(
            self::cURL('https://api.vk.com/method/' . $method . '?' . http_build_query($array)),
            true
        );
    }

    private static function cURL(string $url) : string {
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:72.0) Gecko/20100101 Firefox/72.0',
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
        ]);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}

<?php
/*
 * @ muxui.cc
 */
class VKApplication {
    private static array $json;

    public static function run() : void {
        if (!empty($json = json_decode(file_get_contents('php://input'), true))) {
            self::$json = $json;
        } else {
            self::close();
        }
    }

    public static function type(string $type, callable $function) : bool {
        return self::$json['type'] == $type ? call_user_func($function, self::$json) : self::close();
    }

    public static function on(string $string, callable $function) : bool {
        return strstr(strtolower(self::$json['object']['message']['text']), strtolower($string)) ? call_user_func($function, self::$json) : false;
    }

    public static function close(string $string = 'ok') : bool {
        echo $string;
        return fastcgi_finish_request();
    }
}

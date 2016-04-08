<?php
header("Content-type: text/html; charset=utf-8");
class ConnectClass {

    /**
     * 建立连接超时时间，30秒
     */
    const TIME_OUT = 30;

    static private $_host = '192.168.25.241';
    static private $_port = '2345';

    /**
     * 取一个空闲的socket
     */
    private static function _get_socket()
        {
            $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
            if (!$socket)
                {
                  throw new Exception('Unable to create socket!');
                }
            socket_connect($socket, self::$_host, self::$_port);
            return $socket;
    }


    public static function SendCenterMessage($msg) {
        $result = 0;
        $socket = self::_get_socket();
        socket_send($socket, $msg, strlen($msg), 0);
        socket_recv($socket, $result, 10, 0);
        socket_close($socket);
        return $result;
    }

}

?>
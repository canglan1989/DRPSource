<?php

class httpsqs
{
    public $httpsqs_host;
    public $httpsqs_port;
    public $httpsqs_auth;
    public $httpsqs_charset;

    public function __construct($host = '192.168.224.21', $port = 1218, $auth = '', $charset =
        'utf-8')
    {
        $this->httpsqs_host = $host;
        $this->httpsqs_port = $port;
        $this->httpsqs_auth = $auth;
        $this->httpsqs_charset = $charset;
        return true;
    }

    public function http_post($query, $body)
    {
        $socket = fsockopen($this->httpsqs_host, $this->httpsqs_port, $errno, $errstr, 1);
        if (!$socket)
        {
            return false;
        }
        $out = "POST ${query} HTTP/1.1\r\n";
        $out .= "Host: ${host}\r\n";
        $out .= "Content-Length: " . strlen($body) . "\r\n";
        $out .= "Connection: close\r\n";
        $out .= "\r\n";
        $out .= $body;
        fwrite($socket, $out);
        $line = trim(fgets($socket));
        $header .= $line;
        list($proto, $rcode, $result) = explode(" ", $line);
        $len = -1;
        while (($line = trim(fgets($socket))) != "")
        {
            $header .= $line;
            if (strstr($line, "Content-Length:"))
            {
                list($cl, $len) = explode(" ", $line);
            }
            if (strstr($line, "Pos:"))
            {
                list($pos_key, $pos_value) = explode(" ", $line);
            }
            if (strstr($line, "Connection: close"))
            {
                $close = true;
            }
        }
        if ($len < 0)
        {
            return false;
        }
        $body = @fread($socket, $len);
        fclose($socket);
        $result_array["pos"] = (int)$pos_value;
        $result_array["data"] = $body;
        return $result_array;
    }

    public function put($queue_name=11, $queue_data)
    {
        $result = $this->http_post("/?auth=" . $this->httpsqs_auth . "&charset=" . $this->
            httpsqs_charset . "&name=" . $queue_name . "&opt=put", $queue_data);
        if ($result["data"] == "HTTPSQS_PUT_OK")
        {
            return true;
        } else
            if ($result["data"] == "HTTPSQS_PUT_END")
            {
                return $result["data"];
            }
        return false;
    }
}

<?php

class HttpRequestReceiver {
    private $method;
    private $uri;
    private $headers;
    private $body;

    public function __construct() {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->uri = $_SERVER['REQUEST_URI'];
        $this->headers = getallheaders();
        $this->body = file_get_contents('php://input');
    }

    public function getMethod() {
        return $this->method;
    }

    public function getUri() {
        return $this->uri;
    }

    public function getHeaders() {
        return $this->headers;
    }

    public function getBody() {
        return $this->body;
    }
}


//class HttpResponseSender {
//    private $statusCode;
//    private $headers;
//    private $body;
//    private $charset;
//    private $finalHeaders;
//    private $finalBody;
//
//    public function __construct($statusCode = 200, $headers = [], $body = '', $charset = 'utf-8', $httpMethod = 'GET') {
//        $this->statusCode = $statusCode;
//        $this->headers = $headers;
//        $this->body = $body;
//        $this->charset = $charset;
//        $this->finalHeaders = "";
//        $this->finalBody = "";
//    }
//
//    public function setStatusCode($statusCode) {
//        $this->statusCode = $statusCode;
//    }
//
//    public function addHeader($name, $value) {
//        $this->headers[$name] = $value;
//    }
//
//    public function removeHeader($name) {
//        unset($this->headers[$name]);
//    }
//
//    public function addHeaders(array $headers) {
//        foreach ($headers as $name => $value) {
//            $this->addHeader($name, $value);
//        }
//    }
//
//    public function setBody($body) {
//        $this->body = $body;
//    }
//
//    public function setCharset($charset) {
//        $this->charset = $charset;
//    }
//
//    public function setHttpMethod($httpMethod) {
//        $this->httpMethod = strtoupper($httpMethod);
//    }
//
//    public function send() {
//        $this->prepareHeaders();
//        $this->prepareBody();
//        $this->sendResponse();
//    }
//
//    private function prepareHeaders() {
//        if (!headers_sent()) {
//            $this->finalHeaders .= "HTTP/1.1 {$this->statusCode}\r\n";
//
//            foreach ($this->headers as $name => $value) {
//                $this->finalHeaders .= "$name: $value\r\n";
//            }
//
//            $this->finalHeaders .= "Content-Type: text/html; charset={$this->charset}\r\n";
//        }
//    }
//
//    private function prepareBody() {
//        $this->finalBody = $this->body;
//    }
//
//    private function sendResponse() {
//        fwrite($conn, $this->finalHeaders . "\r\n" . $this->finalBody);
//        fclose($conn);
//    }
//
//    public function setCookie($name, $value, $expire = 0, $path = '/', $domain = '', $secure = false, $httponly = false) {
//        setcookie($name, $value, $expire, $path, $domain, $secure, $httponly);
//    }
//
//    public function sendFile($filePath) {
//        if (file_exists($filePath)) {
//            $this->addHeader('Content-Disposition', 'attachment; filename=' . basename($filePath));
//            $this->setBody(file_get_contents($filePath));
//            $this->send();
//        }
//    }
//
//    public function sendJson(array $data) {
//        $this->addHeader('Content-Type', 'application/json');
//        $this->setBody(json_encode($data));
//        $this->send();
//    }
//}



//while (true) {
//    clearstatcache();
//    if (filemtime('/path/to/your/code') > $lastModifiedTime) {
//        // Обработка изменений в коде
//        echo "Код был изменен!\n";
//        $lastModifiedTime = filemtime('/path/to/your/code');
//    }
//
//    // Пауза, чтобы не нагружать процессор
//    sleep(1);
//}


// изменить конфигурацию extension=sockets

$host = 'localhost';
$port = 8081;

$sock = socket_create_listen($port);

if ($sock === false) {
    echo "Failed to create socket: " . socket_strerror(socket_last_error()) . PHP_EOL;
    exit;
}

socket_getsockname($sock, $addr, $port);

print "Server Listening on $addr:$port\n";

$fp = fopen('port.txt', 'w');

if ($fp === false) {
    echo "Failed to open file for writing\n";
    socket_close($sock);
    exit;
}

fwrite($fp, $port);

fclose($fp);

while ($c = socket_accept($sock)) {
    /* Делайте что-то полезное */

    if (!is_resource($c)) {
        echo "Failed to accept incoming connection\n";
        continue;
    }

    socket_getpeername($c, $raddr, $rport);

    print "Received Connection from $raddr:$rport\n";

    // Здесь можно добавить код для обработки соединения

    // Пример отправки ответа клиенту
    $response = "Hello, Client!";
    socket_write($c, $response, strlen($response));

    socket_close($c);
}

socket_close($sock);
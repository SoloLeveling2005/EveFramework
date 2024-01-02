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

class HttpResponseSender {
    private $statusCode;
    private $headers;
    private $body;
    private $charset;
    private $httpMethod;

    public function __construct($statusCode = 200, $headers = [], $body = '', $charset = 'utf-8', $httpMethod = 'GET') {
        $this->statusCode = $statusCode;
        $this->headers = $headers;
        $this->body = $body;
        $this->charset = $charset;
        $this->httpMethod = strtoupper($httpMethod);
    }

    public function setStatusCode($statusCode) {
        $this->statusCode = $statusCode;
    }

    public function addHeader($name, $value) {
        $this->headers[$name] = $value;
    }

    public function removeHeader($name) {
        unset($this->headers[$name]);
    }

    public function addHeaders(array $headers) {
        foreach ($headers as $name => $value) {
            $this->addHeader($name, $value);
        }
    }

    public function setBody($body) {
        $this->body = $body;
    }

    public function setCharset($charset) {
        $this->charset = $charset;
    }

    public function setHttpMethod($httpMethod) {
        $this->httpMethod = strtoupper($httpMethod);
    }

    public function send() {
        $this->sendHeaders();
        $this->sendBody();
    }

    public function sendHeaders() {
        if (!headers_sent()) {
            header("HTTP/1.1 {$this->statusCode}");

            foreach ($this->headers as $name => $value) {
                header("$name: $value");
            }

            header("Content-Type: text/html; charset={$this->charset}");
        }
    }

    public function sendBody() {
        echo $this->body;
    }

    public function setCookie($name, $value, $expire = 0, $path = '/', $domain = '', $secure = false, $httponly = false) {
        setcookie($name, $value, $expire, $path, $domain, $secure, $httponly);
    }

    public function sendFile($filePath) {
        if (file_exists($filePath)) {
            $this->addHeader('Content-Disposition', 'attachment; filename=' . basename($filePath));
            $this->setBody(file_get_contents($filePath));
            $this->send();
        }
    }

    public function sendJson(array $data) {
        $this->addHeader('Content-Type', 'application/json');
        $this->setBody(json_encode($data));
        $this->send();
    }
}


// Пример использования
$responseSender = new HttpResponseSender();
$responseSender->sendFile('index.html');

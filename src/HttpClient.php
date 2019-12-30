<?php
namespace KGaming\Core;

class HttpClient
{
    protected $http;
    protected $payload = [];
    protected $response = [];
    protected $headers = [];
    protected $options = [];
    protected $messenger;

    public function __construct()
    {
        $this->http = curl_init();
        $this->messenger = new Messenger();
        $this->initHttpOptions();
        $this->setUserAgent("KGaming/HttpClient v.1.0.0 https://github.com/kaisargaming/core-lib.git");
    }

    public function __destruct()
    {
        curl_close($this->http);
    }

    public function request($path, $method = 'GET')
    {
        $this->response = $this->exec($method);
    }

    public function get($uri)
    {
        $this->method = 'GET';
        $this->setUrl($uri);
        return $this;
    }

    public function post($uri=null, $payload=[])
    {
        if ($uri)
        {
            $this->setUrl($uri);
        }
        if (count($payload))
        {
            $this->payload = $payload;
        }
        $this->setOption('post', true);
        return $this;
    }

    public function form()
    {
        $this->setHeader('Content-Type', 'application/x-www-form-urlencoded');
        $this->setOption('post_fields', $this->payload);
        return $this;
    }

    public function json()
    {
        $this->setHeader('Content-Type', 'application/json');
        $this->setHeader('Accept', 'application/json');
        $this->setOption('post_fields', Utils::toJson($this->payload));
        return $this;
    }

    public function exec()
    {
        $this->implementHeaders();
        $this->implementOptions();
        $response = curl_exec($this->http);
        $hsize = curl_getinfo($this->http, CURLINFO_HEADER_SIZE);
        $this->response['header'] = substr($response, 0, $hsize);
        $this->response['body'] = substr($response, $hsize);
        $this->response['http_code'] = curl_getinfo($this->http, CURLINFO_HTTP_CODE);
        return $this;
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function getBody()
    {
        return $this->response['body'];
    }

    public function getHeader()
    {
        return $this->response['header'];
    }

    public function getStatusCode()
    {
        return $this->response['http_code'];
    }

    public function setUrl($url)
    {
        $this->options['url'] = $url;
        return $this;
    }

    public function setOption($opt, $value)
    {
        $this->options[$opt] = $value;
        return $this;
    }

    public function setHeader($header, $value)
    {
        $this->headers[$header] = $value;
        return $this;
    }

    public function setUserAgent($ua_string)
    {
        $this->headers['User-Agent'] = $ua_string;
    }

    public function setPayload($key, $value)
    {
        $this->payload[$key] = $value;
        return $this;
    }

    private function implementHeaders()
    {
        $header_arr = [];
        foreach ($this->headers as $hkey=>$hval)
        {
            $header_arr[] = "{$hkey}: {$hval}";
        }
        $this->options['http_header'] = $header_arr;
    }

    private function implementOptions()
    {
        foreach($this->options as $optkey=>$value)
        {
            switch ($optkey)
            {
                case 'header':
                    curl_setopt($this->http, CURLOPT_HEADER, $value);
                break;
                case 'timeout':
                    curl_setopt($this->http, CURLOPT_TIMEOUT, $value);
                break;
                case 'follow_location':
                    curl_setopt($this->http, CURLOPT_FOLLOWLOCATION, $value);
                break;
                case 'return_transfer':
                    curl_setopt($this->http, CURLOPT_RETURNTRANSFER, $value);
                break;
                case 'post':
                    curl_setopt($this->http, CURLOPT_POST, $value);
                break;
                case 'post_fields':
                    curl_setopt($this->http, CURLOPT_POSTFIELDS, $value);
                break;
                case 'http_header':
                    curl_setopt($this->http, CURLOPT_HTTPHEADER, $value);
                break;
                case 'url':
                    curl_setopt($this->http, CURLOPT_URL, $value);
                break;
                default:
                    $this->messenger->debug(['option' => $optkey], 'HttpClient Option unknown');
            }
        }
    }

    private function initHttpOptions()
    {
        $this->options = [
            'header' => true,
            'timeout' => 90,
            'follow_location' => true,
            'return_transfer' => true,
        ];

    }
}

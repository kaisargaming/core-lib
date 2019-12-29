<?php
namespace KGaming\Core;

interface HttpClientInterface
{
    public function request($path, $method);
    public function get($url);
    public function post($url, $payload);
    public function form();
    public function json();
    public function exec();
    public function setUrl($url);
    public function setOption($option, $value);
    public function setHeader($header, $value);
    public function setPayload($key, $value);
    public function getResponse();
    public function getBody();
    public function getHeader();
    public function getStatusCode();
}

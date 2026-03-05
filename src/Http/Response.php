<?php

namespace App\Http;


class Response{
    private int $statusCode;
    private array $headers=[];
    private mixed $body;

    public function __construct(int $statusCode, array $headers, mixed $body)
    {
       $this->statusCode=$statusCode;
       $this->headers=$headers;
       $this->body=$body;
    }

    
    public function json(array $data, int $status){
        return new self($status,['Content-Type:application/json'],json_encode($data));
    }

    public function send(){+
        http_response_code($this->statusCode);
        foreach ($this->headers as $header => $value){
            header("{$header}: {$value}");
        }
        echo $this->body;
    }
}
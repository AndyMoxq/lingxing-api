<?php
namespace ThankSong\LingXing\Response;

abstract class Response {
    protected $code;
    protected $message;
    protected $body=[];

    public function __construct(array $body){
        $this -> body = $body;
        $this -> code = $body['code'] ?? 10010;
        $this -> message = $body['message'] ?? ($body['msg'] ?? 'unknow message');
        $this -> validate();
    }

    public function getCode(): int{
        return $this -> code;
    }

    public static function format(array $body): static{
        return new static($body);
    }

    public function getBody(): array{
        return $this -> body;
    }

    public function getMessage(): string {
        return $this -> body['message'] ?? ($this -> body['msg'] ?? 'unknow message');
    }

    public function getData(){
        return $this -> body['data'];
    }

    abstract public function validate();
}
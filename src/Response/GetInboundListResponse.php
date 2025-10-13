<?php
namespace ThankSong\LingXing\Response;

class GetInboundListResponse extends LxBasicResponse {
    public function validate(){

    }

    public function getTotal(): int{
      return $this -> getBody()['total'] ?? 0;
    }
}
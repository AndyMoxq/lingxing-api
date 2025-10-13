<?php
namespace ThankSong\LingXing\Response;

class GetSellerListResponse extends LxBasicResponse {
    public function hasMore($length = 200): bool{
        return count($this -> getData()) == $length;
    }

    public function getData(): array {
        return $this -> getBody()['data']['list'] ?? [];
    }

    public function getTotal(){
        return $this -> getBody()['data']['total'] ?? 0;
    }
}
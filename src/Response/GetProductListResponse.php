<?php
namespace ThankSong\LingXing\Response;

class GetProductListResponse extends LxBaseResponse {
    public function getTotal():int{
        return $this -> getBody()['total'] ?? 0;
    }


    public function hasMore(int $length): bool{
        return count($this -> getData()) == $length;
    }
}
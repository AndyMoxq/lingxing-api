<?php
namespace ThankSong\LingXing\Response;

class GetFbaOrderListResponse extends LxBasicResponse{
    
    public function getTotal(): int{
        return $this -> getBody()['total'] ?? 0;
    }
}
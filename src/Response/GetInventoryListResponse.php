<?php
namespace ThankSong\LingXing\Response;

class GetInventoryListResponse extends LxBasicResponse {
    public function getTotal(){
        return $this -> getBody()['total'] ?? 0;
    }
}
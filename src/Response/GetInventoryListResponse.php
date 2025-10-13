<?php
namespace ThankSong\LingXing\Response;

class GetInventoryListResponse extends LxBaseResponse {
    public function getTotal(){
        return $this -> getBody()['total'] ?? 0;
    }
}
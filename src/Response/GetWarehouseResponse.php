<?php
namespace ThankSong\LingXing\Response;

class GetWarehouseResponse extends LxBasicResponse {
    public function getTotal(): int {
        return $this -> getBody()['total'] ?? 0;
    }
}
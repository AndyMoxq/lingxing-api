<?php
namespace ThankSong\LingXing\Response;

class GetWarehouseResponse extends LxBaseResponse {
    public function getTotal(): int {
        return $this -> getBody()['total'] ?? 0;
    }
}
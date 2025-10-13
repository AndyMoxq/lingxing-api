<?php
namespace ThankSong\LingXing\Response;

class GetUserListResponse extends LxBaseResponse {
    public function getData(): array{
        return $this -> getBody()['data'] ?? [];
    }
}
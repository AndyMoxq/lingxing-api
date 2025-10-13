<?php
namespace ThankSong\LingXing\Response;

class GetUserListResponse extends LxBasicResponse {
    public function getData(): array{
        return $this -> getBody()['data'] ?? [];
    }
}
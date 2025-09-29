<?php
namespace ThankSong\LingXing\Response;
use ThankSong\LingXing\Exception\InvalidResponseException;

class GetOrderListResponse extends LxBaseResponse {
    public function getData(): array{
        return $this -> getBody()['data']['list'] ?? [];
    }

    public function getTotal(): int{
        return $this -> getBody()['data']['total'] ?? 0;
    }

    public function hasMore(int $length): bool{
        return count( $this -> getData() ) == $length;
    }

    public function validate(){
        if($this -> getCode() !== 0 ){
            $code = $this -> getCode();
            throw new InvalidResponseException("[{$code}] " . $this -> getMessage());
        }
    }
}
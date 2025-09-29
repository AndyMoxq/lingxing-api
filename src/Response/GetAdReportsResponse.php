<?php

namespace ThankSong\LingXing\Response;
use ThankSong\LingXing\Exception\InvalidResponseException;
class GetAdReportsResponse extends LxBaseResponse
{
    public function validate(){
        if($this -> getCode() !== 0){
            throw new InvalidResponseException("[{$this -> getCode()}] {$this -> getMessage()}");
        }
    }
    public function getTotal(): int{
        return $this -> getBody()['total'] ?? 0;
    }

    public function hasMore(int $length): bool{
        return count($this -> getData()) == $length;
    }
}
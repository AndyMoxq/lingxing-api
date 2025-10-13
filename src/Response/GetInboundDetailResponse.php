<?php

namespace ThankSong\LingXing\Response;
use ThankSong\LingXing\Exception\InvalidResponseException;

class GetInboundDetailResponse extends LxBasicResponse
{
    public function valdidate(){
        if($this -> getCode() !== 0){
            throw new InvalidResponseException($this -> getMessage());
        }
    }
}
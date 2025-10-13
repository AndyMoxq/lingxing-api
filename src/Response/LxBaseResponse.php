<?php
namespace ThankSong\LingXing\Response;

class LxBaseResponse extends Response {
    public function validate(){
        if ($this -> getCode() !== 0) {
            throw new \Exception($this -> getMessage(), 1);
            # code...
        }
    }
}
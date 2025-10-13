<?php
namespace ThankSong\LingXing\Request;
use ThankSong\LingXing\Response\LxBasicResponse;

class LxBasicRequest extends Request {
    public function validate(){
        
    }
    public function send(): LxBasicResponse{
        return LxBasicResponse::format($this -> doRequest());
    }

    

}
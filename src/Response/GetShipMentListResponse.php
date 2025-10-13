<?php

namespace ThankSong\LingXing\Response;

class GetShipMentListResponse extends LxBasicResponse {
    public function getTotal():int {
      return $this -> getBody()['data']['total'] ?? 0;
    }

    public function getData(){
        return $this -> getBody()['data']['list'] ?? [];
    }
}
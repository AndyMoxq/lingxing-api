<?php
namespace ThankSong\LingXing\Request;

use ThankSong\LingXing\Response\GetUserListResponse;

class GetUserListRequest extends LxBasicRequest
{
    public const ROUTE_NAME = '/erp/sc/data/account/lists';
    public const METHOD = 'GET';
    public function __construct(){
        $this->setRouteName(self::ROUTE_NAME)
            ->setMethod(self::METHOD);
    }

    public function send(): GetUserListResponse{
        return GetUserListResponse::format($this->doRequest());
    }
}
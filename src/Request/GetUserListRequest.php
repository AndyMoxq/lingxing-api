<?php
namespace ThankSong\LingXing\Request;

use ThankSong\LingXing\Request\LxBaseRequest;

class GetUserListRequest extends LxBaseRequest
{
    public const ROUTE_NAME = '/erp/sc/data/account/lists';
    public const METHOD = 'GET';
    public function __construct(){
        $this->setRouteName(self::ROUTE_NAME)
            ->setMethod(self::METHOD);
    }
}
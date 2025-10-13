<?php
namespace ThankSong\LingXing\Request;

class GetUserListRequest extends LxBasicRequest
{
    public const ROUTE_NAME = '/erp/sc/data/account/lists';
    public const METHOD = 'GET';
    public function __construct(){
        $this->setRouteName(self::ROUTE_NAME)
            ->setMethod(self::METHOD);
    }
}
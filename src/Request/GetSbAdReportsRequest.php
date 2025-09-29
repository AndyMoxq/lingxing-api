<?php

namespace ThankSong\LingXing\Request;

class GetSbAdReportsRequest extends GetSpAdReportsRequest {
    public const ROUTE_NAME = '/pb/openapi/newad/hsaCampaignReports';
    public function __construct(){
        $this -> setRouteName(self::ROUTE_NAME);
    }
}
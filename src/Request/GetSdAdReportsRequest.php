<?php

namespace ThankSong\LingXing\Request;

class GetSdAdReportsRequest extends GetSpAdReportsRequest {
    public const ROUTE_NAME = '/pb/openapi/newad/sdCampaignReports';
    public function __construct(){
        $this -> setRouteName(self::ROUTE_NAME);
    }
}
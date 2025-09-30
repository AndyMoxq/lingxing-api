<?php

namespace ThankSong\LingXing\Request;

class GetInboundDetailRequest extends LxBaseRequest
{
    public const ROUTE_NAME = '/basicOpen/overSeaWarehouse/stockOrder/detail';
    public function __construct(){
        $this -> setRouteName(self::ROUTE_NAME);
    }

    /**
     * 备货单号
     * @param string $overseas_order_no
     * @return static
     */
    public function setOverseasOrderNo(string $overseas_order_no){
        $this -> setParam('overseas_order_no', $overseas_order_no);
        return $this;
    }

    public function validate(){
        $this -> validateRequiredParams(['overseas_order_no']);
    }
}
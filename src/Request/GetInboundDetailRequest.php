<?php

namespace ThankSong\LingXing\Request;

class GetInboundDetailRequest extends LxBasicRequest
{
    public const ROUTE_NAME = '/basicOpen/overSeaWarehouse/stockOrder/detail';
    public function __construct(string $overseas_order_no = null){
        $this -> setRouteName(self::ROUTE_NAME);
        if (!empty($overseas_order_no)) {
            $this -> setOverseasOrderNo($overseas_order_no);
        }
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
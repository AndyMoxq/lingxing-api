<?php
namespace ThankSong\LingXing\Request;

use InvalidArgumentException;
use ThankSong\LingXing\Response\LxBasicResponse;

class GetAmzOrderDetailRequest extends LxBasicRequest {
    public const ROUTE_NAME = '/erp/sc/data/mws/orderDetail';

    public function __construct(string $order_id = null){
        $this->setRouteName(SELF::ROUTE_NAME);
        if($order_id !== null){
            $this->setOrderId($order_id);
        }
    }

    public function setOrderId(string $order_id): static{
        $this->setParam('order_id', $order_id);
        return $this;
    }

    public function validate(){
        if (empty($this->getParam('order_id'))) {
            throw new InvalidArgumentException('order_id is required');
        }
    }

    public function send(): LxBasicResponse{
        return LxBasicResponse::format($this->doRequest());
    }
}
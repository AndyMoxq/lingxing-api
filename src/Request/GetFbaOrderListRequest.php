<?php
namespace ThankSong\LingXing\Request;

use InvalidArgumentException;
use ThankSong\LingXing\Response\GetFbaOrderListResponse;

class GetFbaOrderListRequest extends LxBasicRequest
{
    public const ROUTE_NAME = '/erp/sc/data/mws/orders';
    public const MAX_LENGTH=5000;
    public const DEFAULT_LENGTH=1000;
    public const SITE_PURCHASED_TIME = 1;
    public const BEIJING_UPDATE_TIME = 2;
    public const UTC_UPDATE_TIME = 3;
    public const SITE_SHIPPED_TIME = 10;

    public function __construct(array $params = []){
        $this -> setRouteName(self::ROUTE_NAME);
        if(!empty($params)){
            $this -> setParams($params);
            if (empty($params['length'])) {
                $this -> setLength(SELF::DEFAULT_LENGTH);
            }
            if (empty($params['offset'])) {
                $this -> setOffset(0);
            }
            if (empty($params['fulfillment_channel'])) {
                $this -> setFulfillmentChannel(1);
            }
            if (empty($params['date_type'])) {
                $this -> setDateType(SELF::SITE_PURCHASED_TIME);
            }
        }
    }

    /**
     * 查询日期类型 1: 站点购买时间 2: 订单修改时间【北京时间】 3:UTC更新时间 10: 站点发货时间
     * @param int $date_type
     * @return static
     */
    public function setDateType(int $date_type): static{
        $this -> setParam('date_type',$date_type);
        return $this;
    }

    /**
     * 设置开始日期 Y-m-d H:i:s
     * @param string $start_date
     * @return static
     */
    public function setStartDate(string $start_date): static{
        $this -> setParam('start_date',$start_date);
        return $this;
    }

    /**
     * 设置结束日期 Y-m-d H:i:s
     * @param string $end_date
     * @return static
     */
    public function setEndDate(string $end_date): static{
        $this -> setParam('end_date',$end_date);
        return $this;
    }

    /**
     * 设置店铺ID
     * @param int $sid
     * @return static
     */
    public function setSid(int $sid){
        $this -> setParam('sid',$sid);
        return $this;
    }

    /**
     * 设置店铺ID列表，最大长度20
     * @param array $sid_list
     * @return static
     */
    public function setSidList(array $sid_list): static{
        if(count($sid_list)>20){
            throw new InvalidArgumentException('sid_list最大长度为20');
        }
        $this -> setParam('sid_list',implode(',',$sid_list));
        return $this;
    }

    /**
     * 设置订单状态 Pending 待处理 | Unshipped 未发货 | PartiallyShipped 部分发货 | Shipped 已发货 | Canceled 取消
     * @param string $status
     * @throws \InvalidArgumentException
     * @return static
     */
    public function setOrderStatus(string $status): static{
        $statues = ['Pending','Unshipped','PartiallyShipped','Canceled'];
        if(!in_array($status,$statues)){
            throw new InvalidArgumentException('订单状态错误,只能' . implode('|', $statues));
        }
        $order_status=$this->getParam('order_status') ?? [];
        if(in_array($status,$order_status)){
            $order_status[]=$status;
        }
        $this -> setParam('order_status',$order_status);
        return $this;
    }

    /**
     * 设置配送方式。1: AFN=亚马逊配送 ｜ 2: MFN=卖家自配送
     * @param int $fulfillment_channel
     * @throws \InvalidArgumentException
     * @return GetFbaOrderListRequest
     */
    public function setFulfillmentChannel(int $fulfillment_channel): static{
        if(!in_array($fulfillment_channel,[1,2])){
            throw new InvalidArgumentException('配送方式设置错误,只能 1: AFN=亚马逊配送 ｜ 2: MFN=卖家自配送' );
        }
        $this -> setParam('fulfillment_channel',$fulfillment_channel);
        return $this;
    }

    /**
     * 设置页偏移
     * @param int $offset
     * @return static
     */
    public function setOffset(int $offset): static{
        $this -> setParam('offset',$offset);
        return $this;
    }

    /**
     * 设置页长度
     * @param int $length
     * @throws \InvalidArgumentException
     * @return static
     */
    public function setLength(int $length): static{
        if($length>SELF::MAX_LENGTH){
            throw new InvalidArgumentException('最大长度不能超过'.self::MAX_LENGTH);
        }
        $this -> setParam('length',$length);
        return $this;
    }

    public function validate(){
        $params = $this ->getParams();
        if (empty($params['start_date']) || empty($params['end_date'])) {
            $errors[] = 'start_date(开始日期)和end_date(结束日期)不能为空';
        }
        if(!isset($params['length'])){
            $errors[] = 'length(页长度)不能为空';
        }
        if(!isset($params['offset'])){
            $errors[] = 'offset(页偏移)不能为空';
        }
        if (!empty($errors)) {
            throw new InvalidArgumentException(implode(',', $errors));
        }
    }

    public function send(): GetFbaOrderListResponse{
        $this -> validate();
        return GetFbaOrderListResponse::format($this -> doRequest());
    }

}
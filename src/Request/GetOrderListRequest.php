<?php
namespace ThankSong\LingXing\Request;

class GetOrderListRequest extends LxBaseRequest {
    public const ROUTE_NAME = '/pb/mp/order/v2/list';
    public const MAX_LENGTH=500;
    public const DEFAULT_LENGTH=20;

    public function __construct(array $params = []){
        $this -> setRouteName(self::ROUTE_NAME)
              -> setLength(self::DEFAULT_LENGTH) 
              -> setDateType();
        if(!empty($params)) $this -> setParams($params);
    }

    public function setDateType(string $date_type = 'update_time'): static{
        $this -> setParam('date_type',$date_type);
        return $this;
    }

    public function setStartTime(int $start_time): static{
        $this -> setParam('start_time',$start_time);
        return $this;
    }

    public function setEndTime(int $end_time): static{
        $this -> setParam('end_time',$end_time);
        return $this;
    }

    /**
     * 添加单一平台CODE，可通过ThankSong\LingXing\Enum\PlatformCodes 中的常量获取常用的平台编号
     * @param string $plarform_code
     * @return GetSellerListRequest
     */
    public function setPlatformCode(string $plarform_code): static{
        $plarform_codes = $this -> params['plarform_code'] ?? [];
        if(!in_array($plarform_code,$plarform_codes)){
            $plarform_codes[] = $plarform_code;
        }
        $this -> setParam('platform_code',$plarform_codes);
        return $this;
    }

    /**
     * 批量添加平台CODE
     * @param array $plarform_codes
     * @return GetSellerListRequest
     */
    public function setPlatformCodes(array $plarform_codes): static{
        foreach ($plarform_codes as $plarform_code) {
            $this -> setPlatformCode($plarform_code);
        }
        return $this;
    }

    /**
     * 平台单号
     * @param string $platform_order_no
     * @return GetOrderListRequest
     */
    public function setPlatformOrderNo(string $platform_order_no): static{
        $platform_order_nos = $this -> params['platform_order_nos'] ?? [];
        if(!in_array($platform_order_no,$platform_order_nos)){
            $platform_order_nos[]=$platform_order_no;
        }
        $this -> setParam('platform_order_nos',$platform_order_nos);
        return $this;
    }

    /**
     * 平台单号列表
     * @param array $platform_order_nos
     * @return static
     */
    public function setPlatformOrderNos(array $platform_order_nos){
        foreach ($platform_order_nos as $platform_order_no) {
            $this -> setPlatformOrderNo($platform_order_no);
        }
        return $this;
    }

    public function validate(){
        if(!empty($this -> params['platform_order_nos'])){
            unset($this -> params['date_type']);
            unset($this -> params['start_time']);
            unset($this -> params['end_time']);
        }
    }

}
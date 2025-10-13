<?php

namespace ThankSong\LingXing\Request;
use Illuminate\Support\Carbon;
use ThankSong\LingXing\Exception\RequestException;
use ThankSong\LingXing\Response\GetShipMentListResponse;

class GetShipMentListRequest extends LxBasicRequest {
    public const ROUTE_NAME = '/erp/sc/routing/storage/shipment/getInboundShipmentList';
    public const DEFAULT_LENGTH = 20;
    public const DEFAULT_OFFSET = 0;

    public const STATUS_WAIT_PACKING = -1;
    public const STATUS_WAIT_DELIVERY = 0;
    public const STATUS_DELIVERED = 1;
    public const STATUS_INVALID = 3;
    public const STATUS_DELETED = 4;

    public const TIME_TYPE_CREATE_TIME = 3;
    public const TIME_TYPE_ARRIVAL_TIME = 1;
    public const TIME_TYPE_DELIVERY_TIME = 0;
    public const TIME_TYPE_UPDATE_TIME = 4;
    public function __construct(){
        $this -> setRouteName(self::ROUTE_NAME);
        $this -> setOffset(self::DEFAULT_OFFSET);
        $this -> setLength(self::DEFAULT_LENGTH);
    }

    /**
     * 设置发货单状态 -1:待配货，0：待发货，1：已发货，3：已作废，4：已删除
     * @param int $status
     * @throws \ThankSong\LingXing\Exception\RequestException
     * @return static
     */
    public function setStatus(int $status){
        if (!in_array($status, [-1, 0, 1, 3, 4])) {
            throw new  RequestException("status must be -1, 0, 1, 3, 4", 1);
        }
        $this -> setParam('status', $status);
        return $this;
    }

    /**
     * 设置时间类型 3创建时间 (允许精确到时分秒) 2创建时间 1到货时间 0发货时间 4更新时间 (允许精确到时分秒)
     * @param int $time_type
     * @throws \ThankSong\LingXing\Exception\RequestException
     * @return static
     */
    public function setTimeType(int $time_type){
        if (!in_array($time_type, [3, 2, 1, 0, 4])) {
             throw new  RequestException("time_type must be 3, 2, 1, 0, 4", 1);
        }
        $this -> setParam('time_type', $time_type);
        return $this;
    }

    /**
     * 设置开始时间 格式 YYYY-MM-DD HH:mm:ss
     * @param string $start_date
     * @return static
     */
    public function setStartDate(string $start_date){
        //校验时间格式
        $start_date = Carbon::createFromFormat('Y-m-d H:i:s', $start_date)->toDateTimeString();
        $this -> setParam('start_date', $start_date);
        return $this;
    }

    /**
     * 设置结束时间 格式 YYYY-MM-DD HH:mm:ss
     * @param string $end_date
     * @return static
     */
    public function setEndDate(string $end_date){
        //校验时间格式
        $end_date = Carbon::createFromFormat('Y-m-d H:i:s', $end_date)->toDateTimeString();
        $this -> setParam('end_date', $end_date);
        return $this;
    }

    public function send(): GetShipMentListResponse{
        return GetShipMentListResponse::format($this -> doRequest());
    }

    public function validate(){
        $this -> validateRequiredParams(['offset', 'length']);
        if(!empty($this -> params['time_type']) || !empty($this -> params['start_date']) || !empty($this -> params['end_date'])){
            $this -> validateRequiredParams(['start_date','end_date','time_type']);
            if(in_array($this -> params['time_type'], [0,1,2])){
                $this -> params['start_date'] = Carbon::createFromFormat('Y-m-d H:i:s', $this -> params['start_date'])->toDateString();
                $this -> params['end_date'] = Carbon::createFromFormat('Y-m-d H:i:s', $this -> params['end_date'])->toDateString();
            }
        }
    }
}
<?php

namespace ThankSong\LingXing\Request;

class GetInboundListRequest extends LxBaseRequest {
    public const ROUTE_NAME = '/erp/sc/routing/owms/inbound/listInbound';

    public function __construct(){
        $this -> setRouteName(self::ROUTE_NAME);
    }

    public function setStatus(int $status){
        $this -> setParam('status', $status);
        return $this;
    }

    public function setSWid(string $s_wid){
        $this -> setParam('s_wid', $s_wid);
        return $this;
    }

    public function setRWid(string $r_wid){
        $this -> setParam('r_wid', $r_wid);
        return $this;
    }

    public function setOverseasOrderNo(string $overseas_order_no){
        $this -> setParam('overseas_order_no', $overseas_order_no);
        return $this;
    }

    public function setCreateTimeFrom(string $create_time_from){
        $this -> setParam('create_time_from', $create_time_from);
        return $this;
    }

    public function setCreateTimeTo(string $create_time_to){
        $this -> setParam('create_time_to', $create_time_to);
        return $this;
    }

    public function setPageNum(int $page){
        $this -> setParam('page', $page);
        return $this;
    }

    public function setPageSize(int $page_size){
        $this -> setParam('page_size', $page_size);
        return $this;
    }

    public function setDateType(string $date_type){
        $this -> setParam('date_type', $date_type);
        return $this;
    }
    
    /**
     * 订单是否删除：0 未删除【默认】 1 已删除 2 全部
     * @param int $is_delete
     * @return static
     */
    public function setIsDelete(int $is_delete){
        $this -> setParam('is_delete', $is_delete);
        return $this;
    }



}
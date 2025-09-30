<?php

namespace ThankSong\LingXing\Request;

class GetInboundListRequest extends LxBaseRequest {
    public const ROUTE_NAME = '/erp/sc/routing/owms/inbound/listInbound';

    public function __construct(array $params = []){
        $this -> setRouteName(self::ROUTE_NAME)->setPageSize(20);
        if(!empty($params)){
            $this -> setParams($params);
        }
    }

    /**
     * 设置状态：10 待审核 ｜ 20 已驳回 ｜ 30 待配货 ｜ 40 待发货 ｜ 50 待收货 ｜ 51 已撤销 ｜ 60 已完成
     * @param int $status
     * @return static
     */
    public function setStatus(int $status){
        if(!in_array($status, [10, 20, 30, 40, 50, 51, 60])){
            throw new \InvalidArgumentException('status参数错误');
        }
        $this -> setParam('status', $status);
        return $this;
    }

    /**
     * 设置发货仓库id
     * @param int $s_wid
     * @return static
     */
    public function setSWid(int $s_wid){
        $s_wids = $this -> params['s_wid'] ?? [];
        if (!in_array($s_wid, $s_wids)) {
            $s_wids[] = $s_wid;
        }
        $this -> setParam('s_wid', $s_wids);
        return $this;
    }

    /**
     * 批量设置发货仓库id
     * @param array $s_wids
     * @return static
     */
    public function setSWids(array $s_wids){
        foreach ($s_wids as $s_wid) {
            $this -> setSWid($s_wid);
        }
        return $this;
    }


    /**
     * 设置收获仓库ID
     * @param int $r_wid
     * @return static
     */
    public function setRWid(int $r_wid){
        $r_wids = $this -> params['r_wid'] ?? [];
        if (!in_array($r_wid, $r_wids)) {
            $r_wids[] = $r_wid;
        }
        $this -> setParam('r_wid', $r_wids);
        return $this;
    }

    /**
     * 批量设置收获仓库ID
     * @param array $r_wids
     * @return static
     */
    public function setRWids(array $r_wids){
        foreach ($r_wids as $r_wid) {
            $this -> setRWid($r_wid);
        }
        return $this;
    }


    /**
     * 设置海外仓备货单号
     * @param string $overseas_order_no
     * @return static
     */
    public function setOverseasOrderNo(string $overseas_order_no){
        $this -> setParam('overseas_order_no', $overseas_order_no);
        return $this;
    }

    /**
     * 查询开始日期，格式：Y-m-d
     * @param string $create_time_from
     * @return static
     */
    public function setCreateTimeFrom(string $create_time_from){
        $this -> setParam('create_time_from', $create_time_from);
        return $this;
    }

    /**
     * 查询结束日期，格式：Y-m-d
     * @param string $create_time_to
     * @return static
     */
    public function setCreateTimeTo(string $create_time_to){
        $this -> setParam('create_time_to', $create_time_to);
        return $this;
    }

    /**
     * 设置当前页码，默认1
     * @param int $page
     * @return static
     */
    public function setPage(int $page){
        $this -> setParam('page', $page);
        return $this;
    }

    /**
     * 分页数量，最大50，默认20
     * @param int $page_size
     * @return static
     */
    public function setPageSize(int $page_size){
        $page_size = min(50, $page_size);
        $this -> setParam('page_size', $page_size);
        return $this;
    }

    /**
     * 备货单时间查询类型： create_time 创建时间（默认） ｜ delivery_time 发货时间 ｜ receive_time 收货时间 ｜ update_time 更新时间
     * @param string $date_type
     * @return static
     */
    public function setDateType(string $date_type){
        if(!in_array($date_type, ['create_time', 'delivery_time','receive_time', 'update_time'])){
            throw new \InvalidArgumentException('date_type参数错误');
        }
        $this -> setParam('date_type', $date_type);
        return $this;
    }
    
    /**
     * 订单是否删除：0 未删除【默认】 1 已删除 2 全部
     * @param int $is_delete
     * @return static
     */
    public function setIsDelete(int $is_delete): static{
        if (!in_array($is_delete, [0, 1, 2])) {
            throw new \InvalidArgumentException('is_delete 参数错误，只能是 0,1,2');
        }
        $this -> setParam('is_delete', $is_delete);
        return $this;
    }

}
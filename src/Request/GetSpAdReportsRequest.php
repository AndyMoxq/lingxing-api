<?php

namespace ThankSong\LingXing\Request;

class GetSpAdReportsRequest extends LxBaseRequest
{
    public const ROUTE_NAME = '/pb/openapi/newad/spCampaignReports';
    public function __construct(){
        $this -> setRouteName(self::ROUTE_NAME);
    }

    /**
     * 店铺id ，对应查询亚马逊店铺列表接口对应字段【sid】
     * @param int $sid
     * @return GetSpAdReportsRequest
     */
    public function setSid(int $sid): static{
        $this -> setParam('sid', $sid);
        return $this;
    }

    /**
     * 报告日期，格式：Y-m-d
     * @param string $report_date
     * @return GetSpAdReportsRequest
     */
    public function setReportDate(string $report_date): static{
        $this -> setParam('report_date', $report_date);
        return $this;
    }

    /**
     * 是否展示完整归因期信息【默认0】：0 否，1 是
     * @param bool $show_detail
     * @return GetSpAdReportsRequest
     */
    public function showDetail(bool $show_detail = true): static{
        $this -> setParam('show_detail', $show_detail ? 1 : 0);
        return $this;
    }


}
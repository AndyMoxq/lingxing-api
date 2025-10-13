<?php
namespace ThankSong\LingXing;
use ThankSong\LingXing\Services\IpService;
use ThankSong\LingXing\Request\LxBasicRequest;
use ThankSong\LingXing\Response\LxBasicResponse;
use ThankSong\LingXing\Request\GetWarehouseRequest;
use ThankSong\LingXing\Response\GetWarehouseResponse;
use ThankSong\LingXing\Request\GetSellerListRequest;
use ThankSong\LingXing\Response\GetSellerListResponse;
use ThankSong\LingXing\Request\GetOrderListRequest;
use ThankSong\LingXing\Response\GetOrderListResponse;
use ThankSong\LingXing\Request\GetProductListRequest;
use ThankSong\LingXing\Response\GetProductListResponse;
use ThankSong\LingXing\Request\GetSbAdReportsRequest;
use ThankSong\LingXing\Request\GetSpAdReportsRequest;
use ThankSong\LingXing\Request\GetSdAdReportsRequest;
use ThankSong\LingXing\Response\GetAdReportsResponse;
use ThankSong\LingXing\Request\GetInboundListRequest;
use ThankSong\LingXing\Response\GetInboundListResponse;
use ThankSong\LingXing\Request\GetInboundDetailRequest;
use ThankSong\LingXing\Response\GetInboundDetailResponse;
use ThankSong\LingXing\Request\GetShipMentListRequest;
use ThankSong\LingXing\Response\GetShipMentListResponse;
use ThankSong\LingXing\Request\GetUserListRequest;
use ThankSong\LingXing\Response\GetUserListResponse;
use ThankSong\LingXing\Request\GetInventoryListRequest;
use ThankSong\LingXing\Response\GetInventoryListResponse;

class LingXing
{
    /**
     * 获取用户列表
     * @return GetUserListResponse
     */
    public static function getUserList(): GetUserListResponse{
        $request = new GetUserListRequest();
        return GetUserListResponse::format($request->doRequest());
    }

    /**
     * 获取IP地址
     * @return string
     */
    public static function getIp(): string{
        return IpService::getIp();
    }
    
    /**
     * 基础请求
     * @param string $routeName
     * @param array $params
     * @param string $method
     * @param array $headers
     * @return LxBasicResponse
     */
    public static function basicRequest( string $routeName,
                                        array $params=[],
                                        string $method='POST',
                                        array $headers=[]): LxBasicResponse{
        $request = new LxBasicRequest();
        $request -> setRouteName($routeName)
                 -> setMethod($method)
                 -> setParams($params)
                 -> setHeaders($headers);
        return LxBasicResponse::format($request->doRequest());
    }

    /**
     * 获取库存明细
     * @param array $params
     * @return GetInventoryListResponse
     */
    public static function getInventoryList(array $params=[]): GetInventoryListResponse{
        $request = new GetInventoryListRequest();
        $request -> setParams($params);
        return GetInventoryListResponse::format($request -> doRequest());
    }

    /**
     * 获取FBA发货单列表
     * @param array $params
     * @return GetOrderListResponse
     */
    public static function getShipmentList(array $params=[]): GetShipMentListResponse{
        $request = new GetShipMentListRequest;
        $request -> setParams($params);
        return GetShipMentListResponse::format($request -> doRequest());
    }

    /**
     * 获取海外仓备货单详情
     * @param string $overseas_order_no
     * @return GetInboundDetailResponse
     */
    public static function getInboundOrderDetail(string $overseas_order_no): GetInboundDetailResponse{
        $request = new GetInboundDetailRequest($overseas_order_no);
        return GetInboundDetailResponse::format($request -> doRequest());
    }

    /**
     * 获取仓库列表
     * @param array $params
     * @return GetWarehouseResponse
     */
    public static function getWarehouses(array $params=[]): GetWarehouseResponse{
        $request = new GetWarehouseRequest;
        $request -> setParams($params);
        return GetWarehouseResponse::format($request -> doRequest());
    }

    /**
     * 获取多平台店铺列表
     * @param array $params
     * @return GetSellerListResponse
     */
    public static function getSellerList(array $params=[]): GetSellerListResponse {
        $request = new GetSellerListRequest;
        $request -> setParams($params);
        return GetSellerListResponse::format($request->doRequest());
    }

    /**
     * 获取订单列表
     * @param array $params
     * @return GetOrderListResponse
     */
    public static function getOrderList(array $params): GetOrderListResponse{
        $request = new GetOrderListRequest($params);
        return GetOrderListResponse::format($request->doRequest());
    }

    /**
     * 获取商品列表
     * @param array $params
     * @return GetProductListResponse
     */
    public static function getProductList(array $params=[]): GetProductListResponse{
        $request = new GetProductListRequest;
        $request -> setParams($params);
        return GetProductListResponse::format($request -> doRequest());
    }

    /**
     * SB广告报表
     * @param array $params
     * @return GetAdReportsResponse
     */
    public static function getSbAdReports(array $params): GetAdReportsResponse{
        $request = new GetSbAdReportsRequest;
        $request -> setParams($params);
        return GetAdReportsResponse::format($request -> doRequest());
    }

    /**
     * AD广告报表
     * @param array $params
     * @return GetAdReportsResponse
     */
    public static function getSpAdReports(array $params): GetAdReportsResponse{
        $request = new GetSpAdReportsRequest;
        $request -> setParams($params);
        return GetAdReportsResponse::format($request -> doRequest());
    }

    /**
     * SD广告报表
     * @param array $params
     * @return GetAdReportsResponse
     */
    public static function getSdAdReports(array $params): GetAdReportsResponse{
        $request = new GetSdAdReportsRequest;
        $request -> setParams($params);
        return GetAdReportsResponse::format($request -> doRequest());
    }

    /**
     * 获取海外仓备货单列表
     * @param array $params
     * @return GetInboundListResponse
     */
    public static function getInboundList(array $params = []):GetInboundListResponse {
        $request = new GetInboundListRequest;
        $request -> setParams($params);
        return GetInboundListResponse::format($request -> doRequest());
    }

    /**
     * 获取供应商列表
     * @param int $offset
     * @param int $length
     * @return LxBasicResponse
     */
    public static function getSupplierList(int $offset=0,int $length=1000): LxBasicResponse{
        return self::basicRequest('/erp/sc/data/local_inventory/supplier',
                                    ['offset'=>$offset,'length'=>$length]);
    }
}

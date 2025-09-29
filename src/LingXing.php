<?php
namespace ThankSong\LingXing;
use ThankSong\LingXing\Request\LxBaseRequest;
use ThankSong\LingXing\Response\LxBaseResponse;
use ThankSong\LingXing\Request\GetWarehouseRequest;
use ThankSong\LingXing\Response\GetWarehouseResponse;
use ThankSong\LingXing\Request\GetSellerListRequest;
use ThankSong\LingXing\Response\GetSellerListResponse;
use ThankSong\LingXing\Request\GetOrderListRequest;
use ThankSong\LingXing\Response\GetOrderListResponse;
use ThankSong\LingXing\Request\GetProductListRequest;
use ThankSong\LingXing\Response\GetProductListResponse;

class LingXing
{
    public static function baseRequest(string $routeName,$params=[]): LxBaseResponse{
        $request = new LxBaseRequest();
        $request -> setRouteName($routeName)
                 -> setParams($params);
        return LxBaseResponse::format($request->doRequest());
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
     * 获取店铺列表
     * @param array $params
     * @return GetSellerListResponse
     */
    public static function getSellerList(array $params=[]): GetSellerListResponse {
        $request = new GetSellerListRequest;
        $request -> setParams($params);
        return GetSellerListResponse::format($request->doRequest());
    }

    public static function getOrderList(array $params): GetOrderListResponse{
        $request = new GetOrderListRequest($params);
        return GetOrderListResponse::format($request->doRequest());
    }

    public static function getProductList(array $params=[]): GetProductListResponse{
        $request = new GetProductListRequest;
        $request -> setParams($params);
        return GetProductListResponse::format($request -> doRequest());
    }
}

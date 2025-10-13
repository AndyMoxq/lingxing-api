<?php
namespace ThankSong\LingXing\Request;

use ThankSong\LingXing\Response\GetProductListResponse;

class GetProductListRequest extends LxBasicRequest {
    public const ROUTE_NAME = '/erp/sc/routing/data/local_inventory/productList';

    public function __construct(){
        $this -> setRouteName(self::ROUTE_NAME)
              -> setOffset(0) 
              -> setLength(1000);
    }

    /**
     * 更新时间-开始时间【时间戳，单位：秒，左闭右开】
     * @param int $update_time_start
     * @return static
     */
    public function setUpdateTimeFrom(int $update_time_start){
        $this -> params['update_time_start'] = $update_time_start;
        return $this;
    }

    /**
     * 更新时间-结束时间【时间戳，单位：秒，左闭右开】
     * @param int $update_time_end
     * @return static
     */
    public function setUpdateTimeTo(int $update_time_end){
        $this -> params['update_time_end'] = $update_time_end;
        return $this;
    }

    /**
     * 创建时间-开始时间【时间戳，单位：秒，左闭右开】 	
     * @param int $create_time_start
     * @return static
     */
    public function setCreateTimeFrom(int $create_time_start){
        $this -> params['create_time_start'] = $create_time_start;
        return $this;
    }

    /**
     * 创建时间-结束时间【时间戳，单位：秒，左闭右开】
     * @param int $create_time_end
     * @return static
     */
    public function setCreateTimeTo(int $create_time_end){
        $this -> params['create_time_end'] = $create_time_end;
        return $this;
    }

    /**
     * 单个添加SKU至SKU列表
     * @param string $sku
     * @return GetProductListRequest
     */
    public function setSku(string $sku): static{
        $sku_list = $this -> params['sku_list'] ?? [];
        if(!in_array($sku,$sku_list)){
            $sku_list[] = $sku;
        }
        $this -> params['sku_list'] = $sku_list;
        return $this;
    }

    /**
     * 批量添加SKU至SKU列表
     * @param array $sku_list
     * @return GetProductListRequest
     */
    public function setSkuList(array $sku_list): static{
        foreach ($sku_list as $sku) {
            $this -> setSku($sku);
        }
        return $this;
    }

    public function send(): GetProductListResponse{
        return GetProductListResponse::format($this -> doRequest());
    }
}
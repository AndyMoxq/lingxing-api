<?php
namespace ThankSong\LingXing\Request;
use ThankSOng\LingXing\Exception\RequestException;
use ThankSong\LingXing\Response\GetInventoryListResponse;

class GetInventoryListRequest extends LxBasicRequest{
    public const ROUTE_NAME = '/erp/sc/routing/data/local_inventory/inventoryDetails';
    public const DEFAULT_LENGTH = 20;
    public const MAX_LENGTH = 800;

    public function __construct(){
        $this -> setRouteName(self::ROUTE_NAME)
            -> setOffset(0)
            -> setLength(self::DEFAULT_LENGTH);
    }

    /**
     * 仓库ID，单个
     * @param string $wid
     */
    public function setWid(string $wid){
        $this -> setParam('wid', $wid);
    }

    /**
     * 仓库ID，多个，逗号分隔
     * @param array $wids
     * @return static
     */
    public function setWids(array $wids){
         $this -> setParam('wid', implode(',', $wids));
         return $this;
    }

    /**
     * SKU，单个,（模糊搜索）
     * @param string $sku
     * @return static
     */
    public function setSku(string $sku){
        $this -> setParam('sku', $sku);
        return $this;
    }

    public function validate(){
        $length = $this -> params['length'] ?? self::DEFAULT_LENGTH;
        if($length > self::MAX_LENGTH){
            throw new RequestException('Length should not be greater than '. self::MAX_LENGTH);
        }
    }

    public function send(): GetInventoryListResponse{
        return GetInventoryListResponse::format($this -> doRequest());
    }
}
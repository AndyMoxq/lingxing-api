<?php
namespace ThankSong\LingXing\Request;
use ThankSong\LingXing\Exception\RequestException;
class GetWarehouseRequest extends LxBaseRequest {
    public const ROUTENAME='/erp/sc/data/local_inventory/warehouse';

    public const TYPE_LOCAL = 1;
    public const TYPE_OVERSEA = 3;
    public const TYPE_AMZ_FBA = 4;
    public const TYPE_AWD = 6;
    public function __construct(){
        $this -> setRouteName(self::ROUTENAME);
    }
    /**
     * 仓库类型 1:本地仓【默认值】| 3:海外仓 | 4:亚马逊平台仓 | 6:AWD仓
     * @param int $type
     * @return static
     * 
     */
    public function setType(int $type = 1){
        if(!in_array($type,[1,3,4,6])){
            throw new RequestException("Warehouse Type Must Be in[1:本地仓[默认值],3:海外仓,4:亚马逊平台仓,6:AWD仓]", 1);
            
        }
        $this -> setParam('type',$type);
        return $this;
    }

    /**
     * Summary of setIsDelete
     * @param bool $is_delete
     * @return static
     * false : 0 未删除【默认值】 1 已删除
     */
    public function setIsDelete(bool $is_delete = false){
        $this -> setParam('is_delete',$is_delete);
        return $this;
    }
}
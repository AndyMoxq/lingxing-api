<?php
namespace ThankSong\LingXing\Request;

class GetSellerListRequest extends LxBasicRequest {
    public const ROUTE_NAME = '/pb/mp/shop/v2/getSellerList';
    public const DEFAULT_LENGTH = 200;

    public function __construct(){
        $this -> setRouteName(self::ROUTE_NAME)
              -> setLength(self::DEFAULT_LENGTH);
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
     * 设置店铺同步状态：1：启用 | 0：停用
     * @param bool $is_sync
     * @return GetSellerListRequest
     */
    public function setIsSync(bool $is_sync = true): static{
        $is_sync = $is_sync ? 1 : 0;
        $this -> setParam('is_sync',$is_sync);
        return $this;
    }

    /**
     * 设置店铺授权状态：1：正常授权 | 0：授权失败
     * @param bool $is_sync
     * @return GetSellerListRequest
     */
    public function setStatus(bool $status = true): static{
        $status = $status ? 1 : 0;
        $this -> setParam('status',$status);
        return $this;
    }
}   
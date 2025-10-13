<?php
namespace ThankSong\LingXing\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use ThankSong\LingXing\Services\OpenAPIRequestService;

abstract class Request {
    protected $request_id;
    protected $appId;
    protected $appSecret;
    protected $host;
    protected $params = [];
    protected $headers = [];
    protected $client;
    protected $method = 'POST';
    protected $routeName;
    protected $accessToken;

    public function getRequestId(){
        return $this -> request_id;
    }

    public function setRequestId(string $requestId){
        $this -> request_id = $requestId;
        return $this;
    }

    public function setAppId(string $appId){
        $this -> appId = $appId;
        return $this;
    }

    public function setAppSecret(string $appSecret){
        $this -> appSecret = $appSecret;
    }

    /**
     * 设置请求域名
     * @param string $host
     * @return Request
     */
    public function setHost(string $host){
        $this -> host = $host;
        return $this;
    }

    /**
     * 批量设置参数
     * @param array $params
     * @return static
     */
    public function setParams(array $params): static{
        $this -> params = $params;
        return $this;
    }

    /**
     * 设置单个参数
     * @param $key
     * @param $value
     * @return Request
     */
    public function setParam($key,$value): static{
        $this -> params[$key] = $value;
        return $this;
    }

    /**
     * 设置请求路径
     * @param string $routeName
     * @return Request
     */
    public function setRouteName(string $routeName): static{
        $this -> routeName = $routeName;
        return $this;
    }

    /**
     * 设置请求方式，POST | GET
     * @param string $method
     * @return Request
     */
    public function setMethod(string $method): static{
        $this -> method = $method;
        return $this;
    }

    /**
     * 设置分页长度
     * @param int $length
     * @return static
     */
    public function setLength(int $length){
        $this -> setParam('length',$length);
        return $this;
    }

    /**
     * 设置分页偏移量
     * @param int $offset
     * @return static
     */
    public function setOffset(int $offset): static{
        $this -> setParam('offset',$offset);
        return $this;
    }

    /**
     * 设置请求头
     * @param array $headers
     * @return static
     */
    public function setHeaders(array $headers): static{
        $this -> headers = $headers;
        return $this;
    }

    /**
     * 验证必填字段
     * @param array $keys
     * @throws \Exception
     * @return void
     */
    public function validateRequiredParams(array $keys){
        $errors = [];
        foreach ($keys as $key){
            if(!isset($this -> params[$key])){
                $errors[] = "Param {$key} is required";
            }
        }
        if(count($errors) > 0){
            throw new \Exception(implode("\n",$errors));
        }
    }

    public function doRequest(){
        $this -> setRequestId(Str::uuid());
        $host = $this -> host ?: config('lingxing.host');
        $appId= $this -> appId ?: config('lingxing.appId');
        $appSecret = $this -> appSecret ?: config('lingxing.appSecret');
        $client = new OpenAPIRequestService($host,$appId,$appSecret);
        if(!Cache::get("{$appId}_access_token")){
            $dto = $client -> generateAccessToken();
            Cache::put("{$appId}_access_token",$dto -> getAccessToken(),$dto -> getExpireAt() - time());
            $client -> setAccessToken($dto -> getAccessToken());
        }else{
            $client -> setAccessToken( Cache::get("{$appId}_access_token"));
        }
        $this -> validate();
        /* dump([
            'request_id' => $this -> getRequestId(),
            'app_id' => $appId,
            'routeName' => $this -> routeName,
            'method' => $this -> method,
            'params' => $this -> params,
            'headers' => $this -> headers,
        ]); */
        return $client -> makeRequest($this -> routeName,$this->method,$this->params,$this -> headers);
    }

    abstract public function validate();

}
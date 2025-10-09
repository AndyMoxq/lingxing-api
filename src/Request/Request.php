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

    public function setHost(string $host){
        $this -> host = $host;
        return $this;
    }

    public function setParams(array $params){
        $this -> params = $params;
        return $this;
    }

    public function setParam($key,$value){
        $this -> params[$key] = $value;
        return $this;
    }

    public function setRouteName(string $routeName){
        $this -> routeName = $routeName;
        return $this;
    }

    public function setMethod(string $method){
        $this -> method = $method;
    }

    public function setLength(int $length){
        $this -> setParam('length',$length);
        return $this;
    }

    public function setOffset(int $offset){
        $this -> setParam('offset',$offset);
        return $this;
    }

    public function setHeaders(array $headers){
        $this -> headers = $headers;
        return $this;
    }

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
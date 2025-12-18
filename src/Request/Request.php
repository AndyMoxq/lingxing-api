<?php
namespace ThankSong\LingXing\Request;
use Illuminate\Support\Facades\Cache;
use InvalidArgumentException;
use ThankSong\LingXing\Services\OpenAPIRequestService;

abstract class Request {
    protected string $request_id = '';
    protected ?string $appId = null;
    protected ?string $appSecret = null;
    protected ?string $host = null;
    protected array $params = [];
    protected array $headers = [];
    protected OpenAPIRequestService $client;
    protected string $method = 'POST';
    protected ?string $routeName = null;

    /**
     * 获取请求ID
     * @return string
     */
    public function getRequestId(): string {
        return $this -> request_id ?? '';
    }

    /**
     * 设置请求ID
     * @param string $requestId
     * @return Request
     */
    public function setRequestId(string $requestId): static {
        $this -> request_id = $requestId;
        return $this;
    }

    /**
     * 设置appId
     * @param string $appId
     * @return static
     */
    public function setAppId(string $appId): static {
        $this -> appId = $appId;
        return $this;
    }

    /**
     * 获取appId
     * @return string
     */
    protected function getAppId(): string {
        if(empty($this -> appId)){
            $this-> setAppId(config('lingxing.appId'));
        }
        return $this -> appId;
    }

    /**
     * 设置appSecret
     * @param string $appSecret
     * @return static
     */
    public function setAppSecret(string $appSecret): static {
        $this -> appSecret = $appSecret;
        return $this;
    }

    /**
     * 获取appSecret
     * @return string
     */
    protected function getAppSecret(): string {
        if(empty($this -> appSecret)){
            $this-> setAppSecret(config('lingxing.appSecret'));
        }
        return $this -> appSecret;
    }

    /**
     * 设置请求域名
     * @param string $host
     * @return Request
     */
    public function setHost(string $host): static {
        $this -> host = $host;
        return $this;
    }

    /**
     * 获取请求域名
     * @return string
     */
    public function getHost(): string {
        if(empty($this -> host)){
            $this-> setHost(config('lingxing.host','https://openapi.lingxing.com'));
        }
        return $this -> host;
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
     * 获取单个参数
     * @param $key
     * @return mixed|null
     */
    public function getParam($key){
        return $this -> params[$key]?? null;
    }

    /**
     * 获取所有参数
     * @return array
     */
    public function getParams(): array{
        return $this -> params;
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
     * @throws InvalidArgumentException
     * @return void
     */
    public function validateRequiredParams(array $keys){
        $errors = [];
        foreach ($keys as $key){
            if(!isset($this -> params[$key])){
                $errors[] = "Param {$key} is required";
            }
        }
        if( \count($errors ) > 0){
            throw new InvalidArgumentException(implode("\n",$errors));
        }
    }

    /**
     * 获取缓存key
     * @return string
     */
    private function getCacheKey(): string {
        return $this->getAppId() . "_access_token";
    }

    /**
     * 获取access_token
     * @param OpenAPIRequestService $client
     * @return string
     */
    protected function getAccessToken(OpenAPIRequestService $client): string {
        $cacheKey = $this->getCacheKey();
        $lockKey  = "lock:{$cacheKey}";
        $token = Cache::get($cacheKey);
        if (!$token) {
            $token = Cache::lock($lockKey, 10)->block(5, function () use ($client, $cacheKey) {
                if ($t = Cache::get($cacheKey)) return $t;
                $dto = $client->generateAccessToken();
                $ttl = max(60, $dto->getExpireAt() - time() - 120);
                Cache::put($cacheKey, $dto->getAccessToken(), $ttl);
                return $dto->getAccessToken();
            });
        }
        return (string) $token;
    }

    /**
     * 执行请求
     * @return array
     * @throws \Exception
     */
    public function doRequest(): array
    {
        $this->validate();
        if (empty($this->routeName)) {
            throw new \RuntimeException('routeName is required');
        }
        $client = new OpenAPIRequestService(
            $this->getHost(),
            $this->getAppId(),
            $this->getAppSecret()
        );

        $client->setAccessToken($this->getAccessToken($client));
        $res = $client->makeRequest(
            $this->routeName, 
            $this->method, 
            $this->params, 
            $this->headers
        );

        $tokenNotMatch = str_contains((string)($res['msg'] ?? ''), 'access token not match');

        if (($res['code'] ?? null) === '2001005' || $tokenNotMatch ) {
            $res = $this->retry($client, 5);
        }
        return $res ?? [];
    }

    /**
     * 重试机制
     * @param OpenAPIRequestService $client
     * @param int $times 重试次数 default 5
     * @return array
     */
    private function retry(OpenAPIRequestService $client, int $times = 5): array
    {
        $cacheKey = $this->getCacheKey();
        for ($i = 1; $i <= $times; $i++) {
            dump("我重试了{$i}次");
            Cache::forget($cacheKey);
            $client->setAccessToken($this->getAccessToken($client));
            $res = $client->makeRequest(
                $this->routeName, 
                $this->method, 
                $this->params, 
                $this->headers
            );
            $tokenNotMatch = str_contains((string)($res['msg'] ?? ''), 'access token not match');
            $isTokenError = (($res['code'] ?? null) === '2001005') || $tokenNotMatch;
            if (! $isTokenError ) {
                return $res;
            }
            sleep(min(1 << $i, 10));
        }

        return [];
    }

    abstract public function validate();

}
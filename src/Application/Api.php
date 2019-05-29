<?php
/**
 * Created by PhpStorm.
 * User: ZXY
 * Date: 2019/5/14
 * Time: 13:09
 */

namespace Codepku\CtiCloud\Application;

use Codepku\CtiCloud\CtiCloud;
use Codepku\CtiCloud\Exception\HttpException;
use Codepku\CtiCloud\Support\Log;
use Codepku\CtiCloud\Traits\HasHttpRequest;
use Pimple\Container;
use Psr\Http\Message\ResponseInterface;

class Api
{
    use HasHttpRequest;

    const BASE_URI = "https://api-%s.cticloud.cn/";

    const BASE_TEST_URI = "https://api-test-%s.cticloud.cn/";
    /**
     * @var Container
     */
    protected $app;

    public function __construct(CtiCloud $app)
    {
        $this->app = $app;
    }


    /**
     * Make a get request.
     *
     * @param string $endpoint
     * @param array  $query
     * @param array  $headers
     ** @throws HttpException
     * @return array
     */
    protected function get($endpoint, $query = [], $headers = [])
    {
        $query = array_merge($query, $this->basicParams());

        return $this->request('get', $endpoint, [
            'headers' => $headers,
            'query' => $query,
        ]);
    }

    /**
     * Make a post request.
     *
     * @param string $endpoint
     * @param array  $params
     * @param array  $headers
     ** @throws HttpException
     * @return array
     */
    protected function post($endpoint, $params = [], $headers = [])
    {
        $params = array_merge($params, $this->basicParams());

        $response =  $this->request('post', $endpoint, [
            'headers' => $headers,
            'form_params' => $params,
        ]);


        return $response;
    }

    /**
     * Make a post request with json params.
     *
     * @param       $endpoint
     * @param array $params
     * @param array $headers
     *
     * @throws HttpException
     * @return array
     */
    protected function postJson($endpoint, $params = [], $headers = [])
    {
        $params = array_merge($params, $this->basicParams());

        return $this->request('post', $endpoint, [
            'headers' => $headers,
            'json' => $params,
        ]);
    }


    /**
     * Make a http request.
     *
     * @param string $method
     * @param string $endpoint
     * @param array  $options  http://docs.guzzlephp.org/en/latest/request-options.html
     * @throws HttpException
     * @return array
     */
    protected function request($method, $endpoint, $options = [])
    {
        $endpoint = $this->splicePath($endpoint);

        Log::debug('CtiCloud Request:', compact('endpoint', 'method', 'options'));

        $response = $this->unwrapResponse($this->getHttpClient($this->getBaseOptions())->{$method}($endpoint, $options));

        if (is_array($response)) {
            Log::debug('CtiCloud response', $response);
        } elseif (is_string($response)) {
            Log::debug("CtiCloud response: $response");
        }

        if (isset($response['result']) and (int) $response['result'] === -1) {
            if (isset($response['errorCode']) and !empty($errMsg = $this->errCodeMap($response['errorCode']))) {
                throw new HttpException($errMsg);
            } else {
                $errMsg = $response['description'] ?? '请求天润融通API出错';
                throw new HttpException($errMsg);
            }
        }

        return $response;
    }

    public function getBaseUri()
    {
        $region = (string) $this->app->getConfig('region');

        if ($this->app->getConfig('env') == 'production') {
            $baseUri = sprintf(self::BASE_URI, $region);
        } else {
            $baseUri = sprintf(self::BASE_TEST_URI, $region);
        }


        return $baseUri;
    }
    /**
     * @param $endPoint
     * @return string
     * 拼接完整的path
     */
    protected function splicePath($endPoint)
    {
        $apiVersion = (string) $this->app->getConfig('version');

        $pathPrefix = sprintf("interface/%s", $apiVersion);

        $endPoint = $pathPrefix . $endPoint;

        return $endPoint;
    }

    /**
     * @return bool
     * 是否通过部门编号鉴权
     */
    protected function validateByDepartment() :bool
    {
        return $this->app->getConfig('validate_type') === 1;
    }

    /**
     * @return bool
     * 是否通过呼叫中心编号鉴权
     */
    protected function validateByEnterprise() :bool
    {
        return $this->app->getConfig('validate_type') === 2;
    }

    /**
     * @return array
     * 获取鉴权编号键值对
     */
    protected function getValidateNo()
    {
        if ($this->validateByDepartment()) {
          return  ['departmentId' => $this->app->getConfig('department_id')];
        }
        return ['enterpriseId' => $this->app->getConfig('enterprise_id')];
    }

    /**
     * @return string
     * 获取签名
     */
    public function getSign()
    {
        $timestamp = time();
        $token = $this->app->getConfig('department_token');

        $validateNo = $this->getValidateNo();
        $validateNo = array_pop($validateNo);

        return md5($validateNo . $timestamp . $token);
    }

    /**
     * @return array
     * 获取基础参数
     */
    protected function basicParams()
    {
        return [
            'validateType' => (int) $this->app->getConfig('validate_type'),
            'timestamp' => time(),
            'sign' => $this->getSign(),
        ] + $this->getValidateNo();
    }

    /**
     * Convert response contents to json.
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return ResponseInterface|array|string
     */
    protected function unwrapResponse(ResponseInterface $response)
    {
        $contentType = $response->getHeaderLine('Content-Type');
        $contents = $response->getBody()->getContents();


        if (false !== stripos($contentType, 'json') || stripos($contentType, 'javascript')
            || stripos($contentType, 'html')) {
            return json_decode($contents, true);
        } elseif (false !== stripos($contentType, 'xml')) {
            return json_decode(json_encode(simplexml_load_string($contents)), true);
        }

        return $contents;
    }

    /**
     * @param $errCode
     * @return null
     * 获取错误码对应的中文解释
     */
    protected function errCodeMap($errCode)
    {
        $errCodeMap = $this->app->getConfig('err_code');

        $errCode = (int) $errCode;
        return $errCodeMap[$errCode] ?? null;
    }
}
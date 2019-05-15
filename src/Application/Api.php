<?php
/**
 * Created by PhpStorm.
 * User: ZXY
 * Date: 2019/5/14
 * Time: 13:09
 */

namespace Junm\CtiCloud\Application;

use Junm\CtiCloud\CtiCloud;
use Junm\CtiCloud\Traits\HasHttpRequest;
use Pimple\Container;

class Api
{
    use HasHttpRequest;

    const BASE_URI = "https://api-%s.cticloud.cn/interface/%s";
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
     *
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
     *
     * @return array
     */
    protected function post($endpoint, $params = [], $headers = [])
    {
        $params = array_merge($params, $this->basicParams());

        return $this->request('post', $endpoint, [
            'headers' => $headers,
            'form_params' => $params,
        ]);
    }

    /**
     * Make a post request with json params.
     *
     * @param       $endpoint
     * @param array $params
     * @param array $headers
     *
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
     *
     * @return array
     */
    protected function request($method, $endpoint, $options = [])
    {
        $endpoint = $this->spliceUrl($endpoint);

        return $this->unwrapResponse($this->getHttpClient($this->getBaseOptions())->{$method}($endpoint, $options));
    }

    /**
     * @param $endPoint
     * @return string
     * 拼接完整的url
     */
    protected function spliceUrl($endPoint)
    {
        $region = (string) $this->app->getConfig('region');

        $apiVersion = (string) $this->app->getConfig('version');

        $baseUri = sprintf(self::BASE_URI, $region, $apiVersion);

        return $baseUri . $endPoint;
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
}
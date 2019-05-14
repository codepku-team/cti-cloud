<?php
/**
 * Created by PhpStorm.
 * User: ZXY
 * Date: 2019/5/14
 * Time: 13:09
 */

namespace Junm\CtiCloud\Application;

use Junm\CtiCloud\CtiCloud;
use Pimple\Container;
use Psr\Http\Message\ResponseInterface;

class Api extends AbstractAPI
{
    /**
     * @var string
     */
    protected $baseUri; //todo

    /**
     * @var Container
     */
    protected $app;

    public function __construct(CtiCloud $app)
    {
        $this->app = $app;
    }


    /**
     * @param $method
     * @param $params
     * @param array $files
     * @return array
     */
    public function request($method, $params, $files = [])
    {
        $http = $this->getHttp();

        $url = $params[0];

        $params = array_merge($params[1], [
            'charset' => 'UTF-8',
        ], $this->basicParams());

        /** @var ResponseInterface $response */
        $response = call_user_func_array([$http, $method], [$url, $params, $files]);

        return json_decode(strval($response->getBody()), true);
    }


    protected function validateByDepartment() :bool
    {
        return $this->app->getConfig('validate_type') === 1;
    }

    protected function validateByEnterprise() :bool
    {
        return $this->app->getConfig('validate_type') === 2;
    }

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


        return md5($id . $timestamp . $token);
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
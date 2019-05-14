<?php
/**
 * Created by PhpStorm.
 * User: ZXY
 * Date: 2019/5/14
 * Time: 13:09
 */

namespace Junm\CtiCloud\Application;

use Psr\Http\Message\ResponseInterface;

class Api extends AbstractAPI
{
    /**
     * @var string
     */
    protected $baseUri; //todo


    public function __construct()
    {

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
            'timestamp' => time(),
        ]);

        //todo add sign to $params about api auth

        /** @var ResponseInterface $response */
        $response = call_user_func_array([$http, $method], [$url, $params, $files]);

        return json_decode(strval($response->getBody()), true);
    }
}
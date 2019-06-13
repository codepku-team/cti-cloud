<?php
/**
 * Created by PhpStorm.
 * User: junm
 * Date: 2019/6/13
 * Time: 12:00
 */

namespace Codepku\CtiCloud\Application\Exten;

use Codepku\CtiCloud\Application\Api;
use Codepku\CtiCloud\Exception\HttpException;

class Exten extends Api
{
    /**
     * @param string $exten
     * @param string $password
     * @param string $areaCode
     * @param array $params
     * @return array
     * @throws HttpException
     */
    public function create(string $exten, string $password, string $areaCode, array $params = [])
    {
        return $this->post('/exten/create', [
            'exten' => $exten,
            'password' => $password,
            'callPower' => isset($params['callPowner']) ? $params['callPowner'] :  0,
            'isOb' => isset($params['isOb']) ? $params['isOb'] : 1,
            'isDirect' => isset($params['isDirect']) ? $params['isDirect'] : 1,
            'ibRecord' => isset($params['ibRecord']) ? $params['ibRecord'] : 1,
            'obRecord' => isset($params['obRecord']) ? $params['obRecord'] : 1,
            'areaCode' => $areaCode,
            'type' => isset($params['type']) ? $params['type'] : 2, //默认rtc
            'allow' => isset($params['allow']) ? $params['allow'] : 'alaw,ulaw'
        ]);
    }


    /**
     * @param $fromExten
     * @param $toExten
     * @param $password
     * @param $areaCode
     * @param array $params
     * @return array
     * @throws HttpException
     */
    public function batchCreate($fromExten, $toExten, $password, $areaCode, array $params = [])
    {
        return $this->post('/exten/batchCreate', [
            'fromExten' => $fromExten,
            'toExten' => $toExten,
            'password' => $password,
            'areaCode' => $areaCode,
            'callPower' => isset($params['callPowner']) ? $params['callPowner'] :  0,
            'isOb' => isset($params['isOb']) ? $params['isOb'] : 1,
            'isDirect' => isset($params['isDirect']) ? $params['isDirect'] : 1,
            'ibRecord' => isset($params['ibRecord']) ? $params['ibRecord'] : 1,
            'obRecord' => isset($params['obRecord']) ? $params['obRecord'] : 1,
            'type' => isset($params['type']) ? $params['type'] : 2, //默认rtc
            'allow' => isset($params['allow']) ? $params['allow'] : 'alaw,ulaw'
        ]);
    }

    /**
     * @param $exten
     * @return array
     * @throws HttpException
     */
    public function detail($exten)
    {
        return $this->get('/exten/get', [
            'exten' => $exten
        ]);
    }

    /**
     * @param array $params
     * @return array
     * @throws HttpException
     */
    public function all(array $params)
    {
        return $this->get('/exten/list', [
            'exten' => $params['exten'] ?? '',
            'callPowner' => isset($params['callPowner']) ? $params['callPowner'] : '',
            'isOb' => isset($params['isOb']) ? $params['isOb'] : '',
            'areaCode' => $params['areaCode'] ?? '',
            'type' => isset($params['type']) ? $params['type'] : '',
            'isBind' => isset($params['isBind']) ? $params['isBind'] : '',
            'limit' => $params['limit'] ?? 500,
            'offset' => $params['offset'] ?? 0
        ]);
    }
}
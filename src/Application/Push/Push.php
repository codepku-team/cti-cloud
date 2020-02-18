<?php
/**
 * Created by PhpStorm.
 * User: lddsb
 * Date: 2019/8/1
 * Time: 11:22
 */

namespace Codepku\CtiCloud\Application\Push;

use Codepku\CtiCloud\Application\Api;
use Codepku\CtiCloud\Exception\HttpException;
use RuntimeException;

class Push extends Api
{
    public const PUSH_ACTION = [
        1 => '来电推送',
        2 => '来电响铃推送',
        3 => '外呼响铃推送',
        4 => 'webcall座席响铃推送',
        5 => '来电接通推送',
        6 => '外呼接通推送',
        7 => '来电挂机推送',
        8 => '外呼挂机推送',
        9 => '座席状态推送',
        10 => '按键推送',
        11 => '号码状态识别推送',
        12 => '录音状态推送',
        13 => 'ASR语音转换结果推送',
    ];

    public const ACTION_PARAMS_MAP = [
        2 => 'PARAMS_RING',
        3 => 'PARAMS_RING',
        4 => 'PARAMS_RING',
        5 => 'PARAMS_CALL_IN_CONNECTED',
        6 => 'PARAMS_CALL_OUT_CONNECTED',
        7 => 'PARAMS_CALL_IN_HANG',
        8 => 'PARAMS_CALL_OUT_HANG',
        9 => 'PARAMS_SEAT_STATUS',
        12 => 'PARAMS_RECORD_STATUS',
    ];

    // 响铃推送设置字段(来电响铃、外呼响铃以及WebCall座席响铃可选字段一致
    public const PARAMS_RING = [
        'event' => 'event',
        'enterpriseId' => 'enterpriseId',
        'hotline' => 'hotline',
        'cno' => 'cno',
        'bindTel' => 'bindTel',
        'customerNumber' => 'customerNumber',
        'customerNumberType' => 'customerNumberType',
        'customerAreaCode' => 'customerAreaCode',
        'callType' => 'callType',
        'numberTrunk' => 'numberTrunk',
        'mainUniqueId' => 'mainUniqueId',
        'uniqueId' => 'uniqueId',
        'qno' => 'qno',
        'ringingTime' => 'ringingTime',
        'consulterCno' => 'consulterCno',
        'transferCno' => 'transferCno'
    ];

    // 呼入接通推送设置字段
    public const PARAMS_CALL_IN_CONNECTED = [
        'event' => 'event',
        'enterpriseId' => 'enterpriseId',
        'customerNumber' => 'customerNumber',
        'cno' => 'cno',
        'bridgeTime' => 'bridgeTime',
        'mainUniqueId' => 'mainUniqueId',
        'calleeNumber' => 'calleeNumber',
        'detailCallType' => 'detailCallType',
        'callType' => 'callType'
    ];

    // 呼出接通推送设置字段
    public const PARAMS_CALL_OUT_CONNECTED = [
        'event' => 'event',
        'enterpriseId' => 'enterpriseId',
        'callType' => 'callType',
        'customerNumber' => 'customerNumber',
        'customerNumberType' => 'customerNumberType',
        'customerAreaCode' => 'customerAreaCode',
        'calleeNumber' => 'calleeNumber',
        'cno' => 'cno',
        'mainUniqueId' => 'mainUniqueId',
        'requestUniqueId' => 'requestUniqueId'
    ];

    // 呼入挂断推送设置字段
    public const PARAMS_CALL_IN_HANG = [
        'cdr_enterprise_id' => '${cdr_enterprise_id}',
        'cdr_main_unique_id' => '${cdr_main_unique_id}',
        'cdr_customer_number' => '${cdr_customer_number}',
        'cdr_customer_area_code' => '${cdr_customer_area_code}',
        'cdr_customer_number_type' => '${cdr_customer_number_type}',
        'cdr_status' => '${cdr_status}',
        'cdr_call_type' => '${cdr_call_type}',
        'cdr_number_trunk' => '${cdr_number_trunk}',
        'cdr_hotline' => '${cdr_hotline}',
        'cdr_callee_cno' => '${cdr_callee_cno}',
        'cdr_join_queue_time' => '${cdr_join_queue_time}',
        'cdr_bridge_time' => '${cdr_bridge_time}',
        'cdr_end_time' => '${cdr_end_time}',
        'cdr_start_time' => '${cdr_start_time}',
        'cdr_record_file_1' => '${cdr_record_file_1}',
        'cdr_end_reason' => '${cdr_end_reason}',
        'cdr_queue' => '${cdr_queue}',
        'cdr_customer_province' => '${cdr_customer_province}',
        'cdr_customer_city' => '${cdr_customer_city}'
    ];

    // 呼出挂断推送设置字段(默认全部外呼都算，包括:预览外呼、WebCall、预测外呼、主叫外呼以及内部外呼)
    public const PARAMS_CALL_OUT_HANG = [
        'cdr_enterprise_id' => '${cdr_enterprise_id}',
        'cdr_main_unique_id' => '${cdr_main_unique_id}',
        'cdr_customer_number' => '${cdr_customer_number}',
        'cdr_customer_area_code' => '${cdr_customer_area_code}',
        'cdr_customer_number_type' => '${cdr_customer_number_type}',
        'cdr_status' => '${cdr_status}',
        'cdr_call_type' => '${cdr_call_type}',
        'cdr_cno' => '${cdr_cno}',
        'cdr_start_time' => '${cdr_start_time}',
        'cdr_bridge_time' => '${cdr_bridge_time}',
        'cdr_answer_time' => '${cdr_answer_time}',
        'cdr_end_time' => '${cdr_end_time}',
        'cdr_request_unique_id' => '${cdr_request_unique_id}',
        'cdr_record_file_1' => '${cdr_record_file_1}',
        'cdr_end_reason' => '${cdr_end_reason}',
        'cdr_agent_number' => '${cdr_agent_number}',
        'cust_callee_clid' => '${cust_callee_clid}',
        'cdr_clid' => '${cdr_clid}',
        'cdr_queue' => '${cdr_queue}',
        'cdr_customer_province' => '${cdr_customer_province}',
        'cdr_customer_city' => '${cdr_customer_city}',
        'cdr_agent_name' => '${cdr_agent_name}'
    ];

    public const PARAMS_SEAT_STATUS = [
        'event',
        'enterpriseId',
        'callType',
        'cno',
        'loginStatus',
        'deviceStatus',
        'pauseDescription',
        'busyDescription',
        'wrapupTime',
        'uniqueId',
        'mainUniqueId',
        'state',
        'stateAction'
    ];

    public const PARAMS_RECORD_STATUS = [
        'cdr_enterprise_id' => '${cdr_enterprise_id}',
        'cdr_unique_id' => '${cdr_unique_id}',
        'cdr_record_file_{index}' => '${cdr_record_file_{index}}',
        'cdr_record_duration' => '${cdr_record_duration}'
    ];

    /**
     * 来电推送
     * 按键推送
     * 号码状态识别推送
     * 录音状态推送
     * ASR语音转换结果推送
     * 满意度调查推送
     * 预测外呼客户接听状态推送
     */

    /**
     * 创建推送设置
     * @param string $url 推送地址
     * @param int $type 推送类型，参见PUSH_ACTION
     * @param array $params 可设置的参数有
     * string url:推送地址;
     * int timeout:超时时间(秒);
     * int retry:重试次数(最大为3);
     * int method:推送方式 0-post，1-get;
     * array param:设置推送参数，参见 PARAMS_xxx 常量;
     * int contentType:推送内容类型 1-form，2-json;
     * int active:是否启用 0-停用,1-启用;
     * int delay:延迟时间(0-900 秒)
     * @return array
     * @throws HttpException
     */
    public function create($url, int $type, $params = []): array
    {
        if (!array_key_exists($type, self::PUSH_ACTION)) {
            throw new RuntimeException('非法的推送类型！');
        }

        $realParams = $this->initParams($params);
        if (isset($params['param'])) {
            [$realParams['paramName'], $realParams['paramVariable']] = $this->getParams($type, $params['param']);
        }

        $realParams['url'] = $url;
        $realParams['type'] = $type;

        return $this->post('/enterprisePushAction/create', $realParams);
    }

    /**
     * 初始化请求参数
     * @param array $params
     * @return array
     */
    private function initParams(array $params): array
    {
        $realParams = [];
        $fieldDefaultMap = [
            'timeout' => 10,
            'retry' => 3,
            'method' => 0,
            'contentType' => 1,
            'active' => 1,
            'delay' => 0,
        ];

        foreach ($fieldDefaultMap as $field => $default) {
            if (!isset($params[$field])) {
                $realParams[$field] = $default;
            } else {
                $realParams[$field] = $params[$field];
            }
        }

        if (isset($params['url'])) {
            $realParams['url'] = $params['url'];
        }

        return $realParams;
    }

    /**
     * 获取加密后的推送参数(其实仅仅做了base64_encode)
     * @param int $type 推送类型
     * @param array $param 推送参数，如果不传默认添加所有可选的参数
     * @return array 返回加密后的参数，格式为[paramName, paramVar] [推送参数, 推送参数对应底层变量]
     */
    private function getParams($type, $param = ['*']): array
    {
        $params = $this->getParamsType($type);
        if (1 === count($param) && '*' === $param[0]) {
            $param = $params;
        } else {
            $param = array_intersect($params, $param);
        }

        // get paramName
        $paramName = implode(',', array_map(static function ($p) {
            return base64_encode($p);
        }, array_keys($param)));

        // get paramVariable
        $paramVars = implode(',', array_map(static function ($p) {
            return base64_encode($p);
        }, array_values($param)));

        return [$paramName, $paramVars];
    }

    /**
     * 根据推送类型获取可用推送参数
     * @param $type
     * @return array
     */
    private function getParamsType($type): array
    {
        if (!array_key_exists($type, self::ACTION_PARAMS_MAP)) {
            throw new RuntimeException('指定的推送设置暂不支持使用API添加，请前往天润后台添加！');
        }

        switch (self::ACTION_PARAMS_MAP[$type]) {
            case 'PARAMS_RING':
                return self::PARAMS_RING;
                break;
            case 'PARAMS_CALL_IN_CONNECTED':
                return self::PARAMS_CALL_IN_CONNECTED;
                break;
            case 'PARAMS_CALL_OUT_CONNECTED':
                return self::PARAMS_CALL_OUT_CONNECTED;
                break;
            case 'PARAMS_CALL_IN_HANG':
                return self::PARAMS_CALL_IN_HANG;
                break;
            case 'PARAMS_CALL_OUT_HANG':
                return self::PARAMS_CALL_OUT_HANG;
                break;
            case 'PARAMS_SEAT_STATUS':
                return self::PARAMS_SEAT_STATUS;
                break;
            case 'PARAMS_RECORD_STATUS':
                return self::PARAMS_RECORD_STATUS;
                break;
        }

        return [];
    }

    /**
     * 更新推送设置
     * @param int $id 推送设置的ID，可通过list()方法获取
     * @param int $type 推送设置的类型
     * @param array $params 可设置的参数有
     * string url:推送地址;
     * int timeout:超时时间(秒);
     * int retry:重试次数(最大为3);
     * int method:推送方式 0-post，1-get;
     * array param:设置推送参数;
     * int contentType:推送内容类型 1-form，2-json;
     * int active:是否启用 0-停用,1-启用;
     * int delay:延迟时间(0-900 秒)
     * @return array
     * @throws HttpException
     */
    public function update($id, $type, array $params): array
    {
        $realParams = $this->initParams($params);

        if (isset($params['param'])) {
            [$realParams['paramName'], $realParams['paramVariable']] = $this->getParams($type);
        }

        $realParams['id'] = $id;
        return $this->post('/enterprisePushAction/update', $realParams);
    }

    /**
     * 删除指定的推送设置
     * @param int $id 推送设置ID，通过list()方法获取
     * @return array
     * @throws HttpException
     */
    public function delete($id): array
    {
        return $this->post('/enterprisePushAction/delete', [
            'id' => $id
        ]);
    }

    /**
     * 获取推送设置列表
     * @param array $types 推送类型，可选多个，默认查全部
     * @return array
     * @throws HttpException
     */
    public function list($types = []): array
    {
        $type = '';
        if (!empty($types)) {
            $type = implode(',', $types);
        }
        return $this->post('/enterprisePushAction/list', [
            'type' => $type
        ]);
    }
}

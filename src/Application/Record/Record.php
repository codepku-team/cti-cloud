<?php
/**
 * Created by PhpStorm.
 * User: wl
 * Date: 2019/5/16
 * Time: 16:38
 */

namespace Codepku\CtiCloud\Application\Record;

use Codepku\CtiCloud\Application\Api;
use Codepku\CtiCloud\Exception\HttpException;

class Record extends Api
{
    /**
     * 获取IVR流程接口
     * */
    public function queryIvrFlow($uniqueId)
    {
        return $this->get('/ivrFlow/query', ['uniqueId' => $uniqueId]);
    }

    /**
     * 获取通话录音地址信息
     * recordType	String	必选	录音类型	record:录音
     * voicemail:留言
     * tsi:彩铃、当开启号码录音状态识别，发起预览外呼，客户号码是手机且客户未接听时返回该地址
     * recordFile	String	必选	录音文件名	如7000101-20160815140025-01087120766-01087120766--record-sip-1-1471240825.87
     * recordFormat	Int	可选	录音类型	取值说明：0为mp3，1为wav，默认为mp3类型
     * callType	Int	可选	呼叫类型	说明：开启分线录音时，获取客户侧或座席侧录音需要，recordFormat=1时有效，recordFormat=0时忽略。取值范围：1,2,4,5（数字含义：呼入,webcall,预览外呼,预测外呼）
     * recordSide	Int	可选	分线录音录音侧	说明：开启分线录音时，获取客户侧或座席侧录音需要，recordFormat=1时有效，recordFormat=0时忽略。取值范围：1,2 (数字含义：客户侧，座席侧)recordSide不为空时，callType必选
     * download	Int	可选	是否下载	１为下载，空或０表示试听
     * */
    public function getUrl($params)
    {
        return $this->get('/record/getUrl', $params);
    }

    /**
     * 获取座席外呼通话记录详情
     * @param $callId
     * @return array
     * @throws HttpException
     */
    public function obDetail($callId)
    {
        return $this->post('/cdr/ob/query', [
            'uniqueId' => $callId
        ]);
    }

    /**
     * 获取预测外呼式外呼通话记录详情
     * @param $callId
     * @return array
     * @throws HttpException
     */
    public function predictiveCallDetail($callId)
    {
        return $this->post('/cdr/predictiveCall/query', [
            'uniqueId' => $callId
        ]);
    }

    /**
     * 获取来电通话记录详情
     * @param $callId
     * @return array
     * @throws HttpException
     */
    public function ibDetail($callId)
    {
        return $this->post('/cdr/ib/query', [
            'uniqueId' => $callId
        ]);
    }

    /**
     * 获取WebCall通话记录详情
     * @param $callId
     * @return array
     * @throws HttpException
     */
    public function webCallDeatil($callId)
    {
        return $this->post('/cdr/webcall/query', [
            'uniqueId' => $callId
        ]);
    }
}
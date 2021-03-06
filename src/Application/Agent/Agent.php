<?php
/**
 * Created by PhpStorm.
 * User: wl
 * Date: 2019/5/16
 * Time: 17:28
 */

namespace Codepku\CtiCloud\Application\Agent;

use Codepku\CtiCloud\Application\Api;
use Codepku\CtiCloud\Exception\HttpException;

class Agent extends Api
{
    /**
     * 通过本接口会自动进行AXB绑定，第三方平台可以给天润托管型呼叫中心发送呼叫请求，天润系统分别呼叫客户和座席，先呼叫客户再呼叫座席,并把双方接通。
     * tel	String	必选	电话号码	需要进行呼叫的客户方电话号码，固话带区号，手机不加0；固话带分机的以'-'分隔。
     * telA	String	可选	AXB绑定中的A号码	需要在企业账户中提前配置
     * telX	String	可选	AXB绑定中的X号码	客户侧的外显号码。如果telX和areaCodeX都不传，默认按照客户号码的区号随机一个
     * areaCodeX	String	可选	X号码区号	表示根据areaCodex随机一个X号码
     * telXGroup	String	可选	X号码组	组名，传入后，X号码从组内选择
     * expiration	Int	可选	绑定关系的有效期	单位为秒，不传默认120秒
     * requestUniqueId	String	可选	请求唯一标识	说明：长度不超过50个字节。1个汉字是3字节。此字段保存到通话记录requestUniqueId字段，后续接口查询使用。一次接口请求造成的多次呼叫requestUniqueId相同
     * userField	String	可选	用户自定义字段	说明：长度不超过250个字节。1个汉字是3字节。此字段保存到通话记录userField字段，后续接口查询使用
     * timeout	Int	可选	呼叫客户超时时间	说明：参数取值范围 0<=timeout<=60；不传入，默认30(单位:s)
     * amd	Int	可选	是否开启amd	自动应答检查（传真机等），1.开启 0.不开启 默认为0
     * delay	Int	可选	延迟时长	秒数，延迟多少秒呼叫 参数取值范围：0<=delay<=60 默认为0
     * ivrId	Int	可选	回呼接通后进入的ivrId	如果不传此参数，使用后台配置的ivr
     * vid	String	可选	用哪种语言播放ivr提示音	1.普通话 2.粤语 4.标贝TTS 默认为1
     * paramNames	String	可选	动态附带参数	参数会写入通道中，以便ivr中调用。 格式：以逗号分隔name1,name2… name必须为字符或数字，参数名建议使用user_开头
     * paramTypes	String	可选	动态参数类型	paramTypes与paramNames给定参数个数必须一致，paramTypes指定了paramNames所给参数的类别，格式：以逗分隔type1,type2,… type1对应paraNames参数中name1，type2对应paraNames参数中name2，以此类推 类型必须为数字,可选值如下：1：普通参数2：需要tts转换的文本参数
     * ${name1}	String	可选	动态参数1	参数值必须使用utf-8编码进行urlencode参数值不能含有逗号’,’，如果有会被转换为中文逗号’，’
     * ${name2}	String	可选	动态参数2	参数值必须使用utf-8编码进行urlencode参数值不能含有逗号’,’，如果有会被转换为中文逗号’，’
     * ...
     *
     * @param $mobile
     * @param $params
     * @return array
     * @throws HttpException
     * */
    public function axbWebcall(string $mobile, array $params = [])
    {
        return $this->post('/axbWebcall', array_merge(['tel' => $mobile], $params));
    }


    /**
     * @param $cno
     * @param $mobile
     * @param array $params
     * @return array
     * @throws HttpException
     */
    public function previewOutcall($cno, $mobile, array $params = []): array
    {
        $params = array_merge(['cno' => $cno, 'tel' => $mobile], $params);

        return $this->post('/previewOutcall', $params);
    }

    /**
     * axb外呼
     * @param $cno
     * @param $mobile
     * @param array $params
     * @return array
     * @throws HttpException
     */
    public function axbOutcall($cno, $mobile, array $params = []) : array
    {
        $params = array_merge(['cno' => $cno, 'tel' => $mobile], $params);

        return $this->post('/axbOutcall', $params);
    }

    /**
     * @param $cno
     * @param $bindTel
     * @param $bindType
     * @param $isVerify
     * @return array
     * @throws  HttpException
     */
    public function changeBindTel($cno, $bindTel, $bindType, $isVerify = 0)
    {
        return $this->post('/agent/changeBindTel', [
            'cno' => $cno,
            'bindTel' => $bindTel,
            'bindType' => $bindType,
            'isVerify' => $isVerify
        ]);
    }

    /**
     * @param $cno
     * @param $bindTel 绑定电话
     * @param $bindType 取值 1.普通电话,2.分机
     * @return array
     * @throws HttpException
     */
    public function login($cno, $bindTel, $bindType)
    {
        return $this->post('/agent/login', [
            'cno' => $cno,
            'bindTel' => $bindTel,
            'bindType' => $bindType
        ]);
    }

    /**
     * 坐席下线
     * @param $cno
     * @param int $removeBinging
     * @param int $isKickout
     * @param int $ignoreOffline
     * @return array
     * @throws HttpException
     */
    public function logout($cno, $removeBinging = 0, $isKickout = 0, $ignoreOffline = 1)
    {
        return $this->post('/agent/logout', [
            'cno' => $cno,
            'removeBinding' => $removeBinging,
            'isKickout' => $isKickout,
            'ignoreOffline' => $ignoreOffline
        ]);
    }

    /**
     * 坐席置闲
     * @param $cno
     * @return array
     * @throws HttpException
     */
    public function unpause($cno)
    {
        return $this->post('/agent/unpause', ['cno' => $cno]);
    }

    /**
     * 坐席置忙
     * @param $cno
     * @param $type
     * @param $description
     * @return array
     * @throws HttpException
     *
     * type 取值说明：1 普通 2 休息 3 IM
     * description 置忙描述
     */
    public function pause($cno, $type, $description)
    {
        return $this->post('/agent/pause', [
            'cno' => $cno,
            'type' => $type,
            'description' => $description
        ]);
    }


    /**
     * 取消座席外呼
     * @param string $cno  座席号
     * @return array
     * @throws HttpException
     */
    public function previewOutcallCancel($cno): array
    {
        return $this->post('/previewOutcallCancel', [
            'cno' => $cno,
        ]);
    }


    /**
     * @param $cno
     * @return array
     * @throws HttpException
     * agent 工具条登录权限认证
     */
    public function authenticate($cno)
    {
        return $this->get('/agentLogin/authenticate', ['cno' => $cno]);
    }
}
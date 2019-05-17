<?php
/**
 * Created by PhpStorm.
 * User: wl
 * Date: 2019/5/16
 * Time: 14:22
 */

namespace Codepku\CtiCloud\Application\Telephone;

use Codepku\CtiCloud\Application\Api;

class Telephone extends Api
{
    /**
     * 新增分机
     * exten	String	必选	分机号,3-11位
     * password	String	必选	密码
     * callPower	String	可选	呼叫权限	0：无限制，1：国内长途，2：国内本市，3：内部呼叫，默认无限制
     * isOb	String	可选	是否允许外呼	0：不允许，1：可以，默认允许
     * isDirect	Int	可选	是否允许摘机外呼，0：不允许，1：可以，默认允许
     * ibRecord	Int	可选	呼入是否录音	0：不录用，1：录音，默认录音
     * obRecord	Int	可选	外呼是否录音	0：不录音，1：录音，默认录音
     * areaCode	String	必选	区号
     * type	Int	必选	类型	1. 注册到IAD分机 2.注册到webrtc 3.注册到远程话机
     * allow	String	可选	语音编码	允许的语音编码,支持格式:
     *                  1. g729
     *                  2. g729,alaw,ulaw
     *                  3. alaw,ulaw,g729
     *                  4. alaw,ulaw
     *                  5. myopus,alaw,ulaw
     *                  公网+远程话机支持配置1/2/3;
     *                  专线+远程话机支持配置1/2;
     *                  公网+软电话支持配置4;
     *                  专线+软电话支持配置5;
     * */
    public function add($params)
    {
        return $this->post('/exten/create',$params);
    }

    /**
     * 删除分机
     * @param $exten Int	必选	分机号,3-11位
     * @return
     * */
    public function delete($exten)
    {
        return $this->get('/exten/delete', ['exten' => $exten]);
    }

    /**
     * 更新分机
     * exten	String	必选	分机号,3-11位
     * password	String	必选	密码
     * callPower	String	可选	呼叫权限	0：无限制，1：国内长途，2：国内本市，3：内部呼叫，默认无限制
     * isOb	String	可选	是否允许外呼	0：不允许，1：可以，默认允许
     * isDirect	Int	可选	是否允许摘机外呼，0：不允许，1：可以，默认允许
     * ibRecord	Int	可选	呼入是否录音	0：不录用，1：录音，默认录音
     * obRecord	Int	可选	外呼是否录音	0：不录音，1：录音，默认录音
     * areaCode	String	必选	区号
     * type	Int	必选	类型	1. 注册到IAD分机 2.注册到webrtc 3.注册到远程话机
     * allow	String	可选	语音编码	允许的语音编码,支持格式:
     *                  1. g729
     *                  2. g729,alaw,ulaw
     *                  3. alaw,ulaw,g729
     *                  4. alaw,ulaw
     *                  5. myopus,alaw,ulaw
     *                  公网+远程话机支持配置1/2/3;
     *                  专线+远程话机支持配置1/2;
     *                  公网+软电话支持配置4;
     *                  专线+软电话支持配置5;
     * */
    public function update($params)
    {
        return $this->post($params);
    }

    /**
     * 查询分机
     * @param $exten
     * @return
     * */
    public function getOne($exten)
    {
        return $this->get('/exten/get', ['exten' => $exten]);
    }

    /**
     * 批量更新分机
     * fromExten	String	必选	起始分机号，3-11位	起始分机号需小于结束分机号
     * toExten	String	必选	结束分机号，3-11位	结束分机号需大于起始分机号
     * password	String	必选	密码
     * callPower	String	可选	呼叫权限，0：无限制，1：国内长途，2：国内本市，3：内部呼叫，默认无限制
     * isOb	String	可选	是否允许外呼，0：不允许，1：可以，默认允许
     * isDirect	Int	可选	是否允许摘机外呼，0：不允许，1：可以，默认允许
     * ibRecord	Int	可选	呼入是否录音，0：不录用，1：录音，默认录音
     * obRecord	Int	可选	外呼是否录音，0：不录音，1：录音，默认录音
     * areaCode	String	必选	区号
     * type	Int	必选	类型，1. 注册到IAD分机 2.注册到webrtc 3.注册到远程话机
     * allow	String	可选	语音编码	允许的语音编码,支持格式:
     *                  1. g729
     *                  2. g729,alaw,ulaw
     *                  3. alaw,ulaw,g729
     *                  4. alaw,ulaw
     *                  5. myopus,alaw,ulaw
     *                  公网+远程话机支持配置1/2/3;
     *                  专线+远程话机支持配置1/2;
     *                  公网+软电话支持配置4;
     *                  专线+软电话支持配置5;
     * */
    public function batchCreate($params)
    {
        return $this->post('/exten/batchCreate', $params);
    }

    /**
     * 批量删除分机
     * @param string $extens 分机号字符串,逗号分隔,最多支持100
     * @return
     * */
    public function batchDelete($extens)
    {
        return $this->get('/exten/batchDelete', ['extens' => $extens]);
    }

    /**
     * 根据条件分页获取分级列表
     * exten	String	可选,3-11位	分机号
     * callPower	String	可选	呼叫权限，0：无限制，1：国内长途，2：国内本市，3：内部呼叫，默认无限制
     * isOb	String	可选	是否允许外呼，0：不允许，1：可以，默认允许
     * ibRecord	Int	可选	呼入是否录音，0：不录用，1：录音，默认录音
     * obRecord	Int	可选	外呼是否录音，0：不录音，1：录音，默认录音
     * areaCode	String	可选	区号
     * type	Int	可选	类型，1. 注册到IAD分机 2.注册到webrtc 3.注册到远程话机
     * isBind	Int	可选	是否被座席绑定，1 绑定 0未绑定
     * limit	Int	可选	条数	正整数 大于0 小于等于500 默认为10条
     * offset	Int	可选	从第几条开始	正整数 默认为0
     * */
    public function paginate($params)
    {
        return $this->get('/exten/list', $params);
    }
}
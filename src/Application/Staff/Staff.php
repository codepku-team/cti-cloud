<?php
/**
 * Created by PhpStorm.
 * User: ZXY
 * Date: 2019/5/14
 * Time: 13:01
 */

namespace Junm\CtiCloud\Application\Staff;


use Junm\CtiCloud\Application\Api;

class Staff extends Api
{
    /**
     * @param $params
     * @return array
     *
     *  crmId	String	必选	员工编号	同一企业员工编号不能重复
        name	String	必选	员工姓名
        pwd	String	必选	员工密码	密码长度在5-30位之间，用户需要自己进行md5加密,加密后密码为32为字符串
        sex	Int	可选	员工性别	0：男性，1：女性
        birth	String	可选	出生日期
        certificateId	String	可选	身份证号
        mobile	String	可选	移动电话
        otherTel	String	可选	联系电话
        fax	String	可选	传真号码
        email	String	可选	电子邮箱
        post	String	可选	邮编
        address	String	可选	地址
        cno	String	可选	座席工号
     * @return array
     */
    public function add($params)
    {
        return $this->post('/personnel/create', $params);
    }

    /**
     * @param $params
     *  crmId	String	必选	员工编号	同一企业员工编号不能重复
        name	String	可选	员工姓名
        pwd	String	可选	员工密码	密码长度在5-30位之间，用户需要自己进行md5加密
        sex	Int	可选	员工性别	0：男性，1：女性
        birth	String	可选	出生日期
        certificateId	String	可选	身份证号
        mobile	String	可选	移动电话
        otherTel	String	可选	联系电话
        fax	String	可选	传真号码
        email	String	可选	电子邮箱
        post	String	可选	邮编
        address	String	可选	地址
        cno	String	可选	座席工号
     * @return array
     */
    public function update($params)
    {
        return $this->post('/personnel/update', $params);
    }

    public function changePwd($crmId, $pwd)
    {
        return $this->post('/personnel/changePwd', ['crmId' => $crmId, 'pwd' => $pwd]);
    }

    public function delete($crmId)
    {
        return $this->post('/personnel/delete', ['crmId' => $crmId]);
    }

    public function detail($crmId)
    {
        return $this->get('/personnel/get', ['crmId' => $crmId]);
    }

    public function all()
    {
        return $this->get('/personnel/list');
    }
}
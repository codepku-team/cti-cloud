<?php
/**
 * Created by PhpStorm.
 * User: ZXY
 * Date: 2019/5/14
 * Time: 20:47
 */

namespace Junm\CtiCloud\AccessToken;


class AccessToken
{
    protected $validateType;

    protected $departmentId;

    protected $enterpriseId;

    protected $signToken;

    protected $authToken;


    public function __construct($validateType, $token, $departmentId = null, $enterpriseId = null)
    {
        $this->validateType = $validateType;

        $this->departmentId = $departmentId;

        $this->signToken = $token;

        $this->enterpriseId = $enterpriseId;
    }


    public function getToken()
    {
        return $this->authToken;
    }

    public function setToken()
    {

    }
    public function signature()
    {
        $result = $this->getToken();


    }
}
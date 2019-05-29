<?php
/**
 * Created by PhpStorm.
 * User: ZXY
 * Date: 2019/5/14
 * Time: 13:01
 */

namespace Codepku\CtiCloud\Application\Skill;


use Codepku\CtiCloud\Application\Api;

class Skill extends Api
{
    public function add($name, $description = '')
    {
        return $this->post('/skill/create', ['name' => $name, 'comment' => $description]);
    }

    public function all($params = [])
    {
        return $this->get('/skill/list', $params);
    }
}
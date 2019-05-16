<?php
/**
 * Created by PhpStorm.
 * User: ZXY
 * Date: 2019/5/14
 * Time: 13:17
 */

namespace Codepku\CtiCloud\Application\Seat;


use Codepku\CtiCloud\Application\Api;

class Seat extends Api
{
    /**
     * @param $params array
     * @return array
     * 新增坐席
     */
    public function add(array $params)
    {
        return $this->post('/agent/create', $params);
    }

    /**
     * @param $cno  int 座席工号
     * @return array
     * 删除坐席
     */
    public function delete(int $cno)
    {
        return $this->post('/agent/delete', ['cno' => $cno]);
    }

    /**
     * @param int $cno
     * @param array $params
     * @return array
     */
    public function update(int $cno, array $params = [])
    {
        return $this->post('/agent/update', array_merge(['cno' => $cno], $params));
    }


}
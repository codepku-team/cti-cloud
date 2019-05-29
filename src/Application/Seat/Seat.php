<?php
/**
 * Created by PhpStorm.
 * User: ZXY
 * Date: 2019/5/14
 * Time: 13:17
 */

namespace Codepku\CtiCloud\Application\Seat;


use Codepku\CtiCloud\Application\Api;
use Codepku\CtiCloud\Exception\HttpException;

class Seat extends Api
{
    /**
     * @param $params array
     * @return array
     * @throws HttpException
     * 新增坐席
     */
    public function add(array $params)
    {
        return $this->post('/agent/create', $params);
    }

    /**
     * @param $cno  int 座席工号
     * @return array
     * @throws HttpException
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
     * @throws HttpException
     */
    public function update(int $cno, array $params = [])
    {
        return $this->post('/agent/update', array_merge(['cno' => $cno], $params));
    }

    /**
     * @param $cno
     * @return array
     * @throws HttpException
     *
     * 获取坐席详情
     */
    public function detail($cno)
    {
        return $this->get('/agent/get', [
            'cno' => $cno
        ]);
    }
}
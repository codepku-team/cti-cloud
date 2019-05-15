<?php
/**
 * Created by PhpStorm.
 * User: ZXY
 * Date: 2019/5/14
 * Time: 13:00
 */

namespace Codepku\CtiCloud\Application\Seat;


use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['seat'] = function ($app) {
            return new Seat($app);
        };
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: ZXY
 * Date: 2019/5/14
 * Time: 20:47
 */

namespace Junm\CtiCloud\AccessToken;


use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['access_token'] = function ($app) {
            return new AccessToken();
        };
    }
}
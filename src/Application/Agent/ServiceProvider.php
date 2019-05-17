<?php
/**
 * Created by PhpStorm.
 * User: wl
 * Date: 2019/5/16
 * Time: 17:39
 */
namespace Codepku\CtiCloud\Application\Agent;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['agent'] = function ($app) {
            return new Agent($app);
        };
    }
}
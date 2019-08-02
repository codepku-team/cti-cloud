<?php
/**
 * Created by PhpStorm.
 * User: lddsb
 * Date: 2019/8/1
 * Time: 11:22
 */
namespace Codepku\CtiCloud\Application\Push;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['push'] = function ($app) {
            return new Push($app);
        };
    }
}
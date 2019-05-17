<?php
/**
 * Created by PhpStorm.
 * User: wl
 * Date: 2019/5/16
 * Time: 16:38
 */

namespace Codepku\CtiCloud\Application\Record;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['record'] = function ($app) {
            return new Record($app);
        };
    }
}
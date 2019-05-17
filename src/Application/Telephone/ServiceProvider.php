<?php
/**
 * Created by PhpStorm.
 * User: wl
 * Date: 2019/5/16
 * Time: 14:15
 */

namespace Codepku\CtiCloud\Application\Telephone;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['telephone'] = function ($app) {
            return new Telephone($app);
        };
    }
}
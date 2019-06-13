<?php
/**
 * Created by PhpStorm.
 * User: junm
 * Date: 2019/6/13
 * Time: 12:00
 */

namespace Codepku\CtiCloud\Application\Exten;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['exten'] = function ($app) {
            return new Exten($app);
        };
    }
}
<?php

namespace Codepku\CtiCloud;

use Codepku\CtiCloud\Support\Config;
use Codepku\CtiCloud\Support\Log;
use Monolog\Handler\HandlerInterface;
use Monolog\Handler\NullHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Pimple\Container;
//use Symfony\Component\HttpFoundation\Request;

class CtiCloud extends Container
{
    /**
     * @var Config
     */
    protected $config;

    protected $providers = [
        //todo required providers
        Application\Staff\ServiceProvider::class,
        Application\Seat\ServiceProvider::class,
        Application\Telephone\ServiceProvider::class,
        Application\Record\ServiceProvider::class,
        Application\Agent\ServiceProvider::class,
        Application\Skill\ServiceProvider::class,
        Application\Exten\ServiceProvider::class,
        Application\Push\ServiceProvider::class,
    ];

    public function __construct(array $config)
    {
        parent::__construct();

        //set config
        $configObject = new Config($config);
        $this->setConfig($configObject);


        if ($this->config->get('debug') ?? false) {
            error_reporting(E_ALL);
        }

        $this->registerProviders();

        $this->registerBase();

        $this->initializeLogger();

    }


    public function setConfig(Config $config)
    {
        $this->config = $config;
    }

    public function getConfig($key = null)
    {
        return $this->config->get($key);
    }


    protected function registerProviders()
    {
        foreach ($this->providers as $provider) {
            $this->register(new $provider());
        }
    }


    private function registerBase()
    {
//        $this['request'] = function () {
//            return Request::createFromGlobals();
//        };
        //todo more ?

    }


    private function initializeLogger()
    {
        if (Log::hasLogger()) {
            return;
        }

        $logger = new Logger($this->getConfig('log.name') ?? 'cti-cloud');

        if (!$this->getConfig('debug') ?? false || defined('PHPUNIT_RUNNING')) {
            $logger->pushHandler(new NullHandler());
        } elseif (($this->getConfig('log.handler') ?? null) instanceof HandlerInterface) {
            $logger->pushHandler($this->getConfig('log.handler'));
        } elseif ($logFile = $this->getConfig('log.file') ?? null) {
            $logger->pushHandler(new StreamHandler(
                $logFile,
                $this->getConfig('log.level') ?? Logger::WARNING,
                true,
                $this->getConfig('log.permission') ?? null
            ));
        }

        Log::setLogger($logger);
    }

    /**
     * Magic get access.
     *
     * @param string $id
     *
     * @return mixed
     */
    public function __get($id)
    {
        return $this->offsetGet($id);
    }

    /**
     * Magic set access.
     *
     * @param string $id
     * @param mixed  $value
     */
    public function __set($id, $value)
    {
        $this->offsetSet($id, $value);
    }
}
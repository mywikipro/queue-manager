<?php

namespace MyWikiPRO\Component\QueueManager\Configuration;

use MyWikiPRO\Component\QueueManager\Adapter\Mock\MockConfiguration;
use MyWikiPRO\Component\QueueManager\Configuration\BindConfiguration;

/**
 * Class Configuration
 * @package MyWikiPRO\Component\QueueManager\Configuration
 */
class Configuration
{
    /**
     * @var array
     */
    private $config;

    /**
     * Constructor
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @return MockConfiguration
     */
    public function getAdapterConfig()
    {
        if ( ! isset($this->config['adapter']['type'])) {
            throw new \RuntimeException('No adapter');
        }

        $configuration = new MockConfiguration();
        foreach ($this->config['adapter']['messages'] as $message) {
            $configuration->getEncodedMessageCollection()->attach($message);
        }

        return $configuration;
    }

    /**
     * @param string $name
     * @return QueueConfiguration
     */
    public function getQueueConfig($name)
    {
        return new QueueConfiguration($name, 0);
    }

    /**
     * @param $name
     * @return ExchangeConfiguration
     */
    public function getExchangeConfig($name)
    {
        return new ExchangeConfiguration($name, 'fanout');
    }

    /**
     * @return BindConfiguration[]
     */
    public function getBindConfigCollection()
    {
        return [];
    }
}

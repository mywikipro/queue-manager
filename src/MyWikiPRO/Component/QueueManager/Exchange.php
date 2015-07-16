<?php

namespace MyWikiPRO\Component\QueueManager;

use MyWikiPRO\Component\QueueManager\Adapter\AdapterInterface;
use MyWikiPRO\Component\QueueManager\Configuration\ExchangeConfiguration;

/**
 * Менеджер очередей / Обменник
 *
 * Class Exchange
 * @package MyWikiPRO\Component\QueueManager\Exchange
 */
final class Exchange
{
    const TYPE_DIRECT = 'direct';
    const TYPE_TOPIC  = 'topic';
    const TYPE_FANOUT = 'fanout';

    /**
     * @var AdapterInterface
     */
    private $adapter;

    /**
     * @var ExchangeConfiguration
     */
    private $configuration;

    /**
     * Constructor
     *
     * @param AdapterInterface $adapter
     * @param ExchangeConfiguration    $configuration
     */
    public function __construct(AdapterInterface $adapter, ExchangeConfiguration $configuration)
    {
        $this->adapter       = $adapter;
        $this->configuration = $configuration;
    }

    /**
     * Название обменника
     *
     * @return string
     */
    public function getName()
    {
        return $this->configuration->getName();
    }

    /**
     * Отправить сообщение в очередь
     *
     * @param string $routingKey
     * @param mixed  $message
     * @param string $contentType
     * @param int    $attempt
     * @param int    $priority
     *
     * @return $this
     */
    public function publish($routingKey, $message, $contentType, $attempt = 0, $priority = 0)
    {
        $this->adapter->publish($this->configuration, $routingKey, $message, $contentType, $attempt, $priority);
        return $this;
    }
}

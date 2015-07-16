<?php

namespace MyWikiPRO\Component\QueueManager\Configuration;

/**
 * Менеджер очередей / Конфигурация связи обменника с очередью
 *
 * Class Configuration
 * @package MyWikiPRO\Component\QueueManager\Bind
 */
class BindConfiguration
{
    /**
     * @var ExchangeConfiguration
     */
    private $exchange;

    /**
     * @var QueueConfiguration
     */
    private $queue;

    /**
     * @var string
     */
    private $routingKey;

    /**
     * Constructor
     *
     * @param ExchangeConfiguration $exchange
     * @param QueueConfiguration    $queue
     * @param string                $routingKey
     */
    public function __construct(ExchangeConfiguration $exchange, QueueConfiguration $queue, $routingKey)
    {
        $this->exchange   = $exchange;
        $this->queue      = $queue;
        $this->routingKey = $routingKey;
    }

    /**
     * Обменник
     *
     * @return ExchangeConfiguration
     */
    public function getExchangeConfiguration()
    {
        return $this->exchange;
    }

    /**
     * Очередь
     *
     * @return QueueConfiguration
     */
    public function getQueueConfiguration()
    {
        return $this->queue;
    }

    /**
     * Ключ для связи
     *
     * @return string
     */
    public function getRoutingKey()
    {
        return $this->routingKey;
    }

    /**
     * Hash для проверки уникальности связи
     *
     * @return string
     */
    public function getHash()
    {
        return md5($this->exchange->getName() . $this->queue->getName() . $this->routingKey);
    }
}

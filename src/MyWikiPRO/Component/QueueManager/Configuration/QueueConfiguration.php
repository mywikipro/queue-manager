<?php

namespace MyWikiPRO\Component\QueueManager\Configuration;

/**
 * Менеджер очередей / Конфигурация очереди
 *
 * Class QueueConfiguration
 * @package MyWikiPRO\Component\QueueManager\Configuration
 */
final class QueueConfiguration
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $timeout;

    /**
     * @var int
     */
    private $maxPriority;

    /**
     * @var BindConfiguration
     */
    private $timeoutRoute;

    /**
     * @var BindConfiguration
     */
    private $rejectRoute;

    /**
     * Constructor
     *
     * @param string $name
     * @param int    $timeout
     */
    public function __construct($name, $timeout = 0)
    {
        $this->name     = $name;
        $this->timeout  = $timeout;
    }

    /**
     * Название очереди
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Время жизни сообщения
     *
     * @return int
     */
    public function getTimeout()
    {
        return $this->timeout;
    }

    /**
     * Время жизни сообщения
     *
     * @return int
     */
    public function getMicroTimeout()
    {
        return $this->timeout * 1000;
    }

    /**
     * Очередь с приоритетом
     *
     * @param int $maxPriority
     * @return $this
     */
    public function setMaxPriority($maxPriority)
    {
        $this->maxPriority = (int)$maxPriority;
        return $this;
    }

    /**
     * Очередь с приоритетом
     *
     * @return int
     */
    public function getMaxPriority()
    {
        return $this->maxPriority;
    }

    /**
     * Задать роут при протухании
     *
     * @param ExchangeConfiguration $exchangeConfiguration
     * @param string                $routingKey
     *
     * @return $this
     */
    public function setTimeoutRoute(ExchangeConfiguration $exchangeConfiguration, $routingKey)
    {
        $this->timeoutRoute = new BindConfiguration($exchangeConfiguration, $this, $routingKey);
        return $this;
    }

    /**
     * Роут при протухании сообщения
     *
     * @return BindConfiguration|null
     */
    public function getTimeoutRoute()
    {
        return $this->timeoutRoute ? clone $this->timeoutRoute : null;
    }

    /**
     * Задать роут при ошибке в обработке
     *
     * @param ExchangeConfiguration $exchangeConfiguration
     * @param string                $routingKey
     *
     * @return $this
     */
    public function setRejectRoute(ExchangeConfiguration $exchangeConfiguration, $routingKey)
    {
        $this->rejectRoute = new BindConfiguration($exchangeConfiguration, $this, $routingKey);
        return $this;
    }

    /**
     * Роут при ошибке в обработке
     *
     * @return BindConfiguration|null
     */
    public function getRejectRoute()
    {
        return $this->rejectRoute ? clone $this->rejectRoute : null;
    }
}

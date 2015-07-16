<?php

namespace MyWikiPRO\Component\QueueManager\Adapter;

use MyWikiPRO\Component\QueueManager\Configuration\ExchangeConfiguration;
use MyWikiPRO\Component\QueueManager\Configuration\QueueConfiguration;
use MyWikiPRO\Component\QueueManager\Entity\MessageInterface;

/**
 * Менеджер очередей / Интерфейс адаптера очередей
 *
 * Interface AdapterInterface
 * @package MyWikiPRO\Component\QueueManager\Adapter
 */
interface AdapterInterface
{
    const TYPE_RABBIT = 'rabbit';
    const TYPE_MOCK   = 'mock';

    /**
     * Связать очередь с обменником
     *
     * @param ExchangeConfiguration    $exchangeConfig
     * @param QueueConfiguration $queueConfig
     * @param string                   $routingKey
     *
     * @return bool
     */
    public function bind(ExchangeConfiguration $exchangeConfig, QueueConfiguration $queueConfig, $routingKey);

    /**
     * Отправить сообщение в очередь
     *
     * @param ExchangeConfiguration $configuration
     * @param string                $routingKey
     * @param string                $message
     * @param string                $contentType
     * @param int                   $attempt
     * @param int                   $priority
     *
     * @return bool
     */
    public function publish(
        ExchangeConfiguration $configuration,
        $routingKey,
        $message,
        $contentType,
        $attempt,
        $priority
    );

    /**
     * Получить сообщение из очереди
     *
     * @param QueueConfiguration $configuration
     * @return MessageInterface|null
     */
    public function get(QueueConfiguration $configuration);

    /**
     * Удалить сообщение из очереди
     *
     * @param QueueConfiguration $configuration
     * @param mixed               $id
     *
     * @return bool
     */
    public function ack(QueueConfiguration $configuration, $id);

    /**
     * Положить сообщение назад в очередь
     *
     * @param QueueConfiguration $configuration
     * @param mixed               $id
     *
     * @return bool
     */
    public function nack(QueueConfiguration $configuration, $id);
}

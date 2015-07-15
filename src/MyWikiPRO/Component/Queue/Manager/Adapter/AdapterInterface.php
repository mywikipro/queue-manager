<?php

namespace MyWikiPRO\Component\Queue\Manager\Adapter;

use MyWikiPRO\Component\Queue\Entity\MessageInterface;
use MyWikiPRO\Component\Queue\Manager\Exchange;
use MyWikiPRO\Component\Queue\Manager\Queue;

/**
 * Менеджер очередей / Интерфейс адаптера очередей
 *
 * Interface AdapterInterface
 * @package MyWikiPRO\Component\Queue\Manager\Adapter
 */
interface AdapterInterface
{
    const TYPE_RABBIT = 'rabbit';
    const TYPE_MOCK   = 'mock';

    /**
     * Инициализация адаптера
     *
     * @return bool
     */
    public function init();

    /**
     * Связать очередь с обменником
     *
     * @param Exchange\Configuration $exchangeConfig
     * @param Queue\Configuration    $queueConfig
     * @param string                 $routingKey
     *
     * @return bool
     */
    public function bind(Exchange\Configuration $exchangeConfig, Queue\Configuration $queueConfig, $routingKey);

    /**
     * Отправить сообщение в очередь
     *
     * @param Exchange\Configuration $configuration
     * @param string                 $routingKey
     * @param string                 $message
     * @param string                 $contentType
     * @param int                    $attempt
     * @param int                    $priority
     *
     * @return bool
     */
    public function publish(
        Exchange\Configuration $configuration,
        $routingKey,
        $message,
        $contentType,
        $attempt,
        $priority
    );

    /**
     * Получить сообщение из очереди
     *
     * @param Queue\Configuration $configuration
     * @return MessageInterface|null
     */
    public function get(Queue\Configuration $configuration);

    /**
     * Удалить сообщение из очереди
     *
     * @param Queue\Configuration $configuration
     * @param mixed               $id
     *
     * @return bool
     */
    public function ack(Queue\Configuration $configuration, $id);

    /**
     * Положить сообщение назад в очередь
     *
     * @param Queue\Configuration $configuration
     * @param mixed               $id
     *
     * @return bool
     */
    public function nack(Queue\Configuration $configuration, $id);
}

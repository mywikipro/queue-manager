<?php

namespace MyWikiPRO\Component\Queue\Event;

use MyWikiPRO\Component\Queue\Consumer\PluginTypeInterface;

/**
 * Менеджер очередей / Интерфейс события обрабатываемого через очередь
 *
 * Interface EventInterface
 * @package MyWikiPRO\Component\Queue\Event
 */
interface EventInterface extends PluginTypeInterface
{
    const TYPE_QUEUE_MOCK_EVENT      = 'QueueMockEvent';
    const TYPE_QUEUE_PARSER_EVENT    = 'QueueParserEvent';
    const TYPE_QUEUE_SERIALIZE_EVENT = 'QueueSerializeEvent';

    /**
     * Имя обменника через который отправлять сообщение
     *
     * @return string
     */
    public function getExchangeName();

    /**
     * Роут для очередей
     *
     * @return string
     */
    public function getRoutingKey();

    /**
     * Количество попыток отправки
     *
     * @return int
     */
    public function getAttemptCount();

    /**
     * Задать приоритет обработки
     *
     * @return int
     */
    public function getPriority();
}

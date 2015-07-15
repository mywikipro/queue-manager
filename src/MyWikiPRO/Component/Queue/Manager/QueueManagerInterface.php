<?php

namespace MyWikiPRO\Component\Queue\Manager;

/**
 * Менеджер очередей / Интерфейс менеджера очередей
 *
 * Interface QueueManagerInterface
 * @package MyWikiPRO\Component\Queue\Manager
 */
interface QueueManagerInterface
{
    /**
     * Получить ссылку на обменник
     *
     * @param string $name
     * @return Exchange\ExchangeInterface
     */
    public function getExchange($name);

    /**
     * Получить ссылку на очередь
     *
     * @param string $name
     * @return Queue\QueueInterface
     */
    public function getQueue($name);
}

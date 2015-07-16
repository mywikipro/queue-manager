<?php

namespace MyWikiPRO\Component\QueueManager;

/**
 * Менеджер очередей / Интерфейс менеджера очередей
 *
 * Interface QueueManagerInterface
 * @package MyWikiPRO\Component\QueueManager
 */
interface QueueManagerInterface
{
    /**
     * Получить ссылку на обменник
     *
     * @param string $name
     * @return Exchange
     */
    public function getExchange($name);

    /**
     * Получить ссылку на очередь
     *
     * @param string $name
     * @return Queue
     */
    public function getQueue($name);

    /**
     * Связать все обменники с очередями
     *
     * @return $this
     */
    public function bind();
}

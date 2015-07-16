<?php

namespace MyWikiPRO\Component\QueueManager\Adapter;

/**
 * Менеджер очередей / Интерфейс конфигурации
 *
 * Interface ConfigurationInterface
 * @package MyWikiPRO\Component\QueueManager\Adapter
 */
interface ConfigurationInterface
{
    /**
     * Тип конфигурации
     *
     * @return string
     */
    public function getType();
}

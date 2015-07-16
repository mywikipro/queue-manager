<?php

namespace MyWikiPRO\Component\QueueManager\Consumer;

/**
 * Менеджер очередей / Интерфейс плагина с типом
 *
 * Interface PluginTypeInterface
 * @package MyWikiPRO\Component\QueueManager\Consumer
 */
interface PluginTypeInterface
{
    /**
     * Тип события
     *
     * @return int
     */
    public function getType();
}

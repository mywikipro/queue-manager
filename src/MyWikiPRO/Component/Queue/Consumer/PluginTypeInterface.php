<?php

namespace MyWikiPRO\Component\Queue\Consumer;

/**
 * Менеджер очередей / Интерфейс плагина с типом
 *
 * Interface PluginTypeInterface
 * @package MyWikiPRO\Component\Queue\Consumer
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

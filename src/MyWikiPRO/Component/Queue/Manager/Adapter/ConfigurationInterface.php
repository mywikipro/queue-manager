<?php

namespace MyWikiPRO\Component\Queue\Manager\Adapter;

/**
 * Менеджер очередей / Интерфейс конфигурации
 *
 * Interface ConfigurationInterface
 * @package MyWikiPRO\Component\Queue\Manager\Adapter
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

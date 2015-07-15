<?php

namespace MyWikiPRO\Component\Queue\Manager\Configuration;

use MyWikiPRO\Component\Queue\Manager\Queue;
use MyWikiPRO\Component\Queue\Manager\Exchange;
use MyWikiPRO\Component\Queue\Manager\Bind;

/**
 * Менеджер очередей / Интерфейс парсера конфигурации
 *
 * Class ConfigurationInterface
 * @package MyWikiPRO\Component\Queue\Manager\Configuration
 */
interface ConfigurationInterface
{
    /**
     * Конфигурация адаптера
     *
     * @return \MyWikiPRO\Component\Queue\Manager\Adapter\ConfigurationInterface
     */
    public function getAdapterConfig();

    /**
     * Коллекция очередей
     *
     * @return Queue\ConfigurationCollection
     */
    public function getQueueCollection();

    /**
     * Коллекция обменников
     *
     * @return Exchange\ConfigurationCollection
     */
    public function getExchangeCollection();

    /**
     * Коллекция связей
     *
     * @return Bind\Collection
     */
    public function getBindCollection();
}

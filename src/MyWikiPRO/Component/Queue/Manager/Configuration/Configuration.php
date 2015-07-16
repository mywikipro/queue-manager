<?php

namespace MyWikiPRO\Component\Queue\Manager\Configuration;

use MyWikiPRO\Component\Queue\Manager\Adapter\ConfigurationInterface as AdapterConfigurationInterface;
use MyWikiPRO\Component\Queue\Manager\Queue;
use MyWikiPRO\Component\Queue\Manager\Exchange;
use MyWikiPRO\Component\Queue\Manager\Bind;

/**
 * Менеджер очередей / Конфигурация менеджера очередей
 *
 * Class Configuration
 * @package MyWikiPRO\Component\Queue\Manager\Configuration
 */
class Configuration
{
    /**
     * @var AdapterConfigurationInterface
     */
    private $adapterConfig;

    /**
     * @var Queue\ConfigurationCollection
     */
    private $queueConfigurationCollection;

    /**
     * @var Exchange\ConfigurationCollection
     */
    private $exchangeConfigurationCollection;

    /**
     * @var Bind\Collection
     */
    private $bindCollection;

    /**
     * Constructor
     *
     * @param AdapterConfigurationInterface    $adapterConfig
     * @param Queue\ConfigurationCollection    $queueConfigurationCollection
     * @param Exchange\ConfigurationCollection $exchangeConfigurationCollection
     * @param Bind\Collection                  $bindCollection
     */
    public function __construct(
        AdapterConfigurationInterface    $adapterConfig,
        Queue\ConfigurationCollection    $queueConfigurationCollection,
        Exchange\ConfigurationCollection $exchangeConfigurationCollection,
        Bind\Collection                  $bindCollection
    ) {
        $this->adapterConfig                   = $adapterConfig;
        $this->queueConfigurationCollection    = $queueConfigurationCollection;
        $this->exchangeConfigurationCollection = $exchangeConfigurationCollection;
        $this->bindCollection                  = $bindCollection;
    }

    /**
     * Конфигурация адаптера
     *
     * @return AdapterConfigurationInterface
     */
    public function getAdapterConfig()
    {
        return $this->adapterConfig;
    }

    /**
     * Коллекция очередей
     *
     * @return Queue\ConfigurationCollection
     */
    public function getQueueCollection()
    {
        return $this->queueConfigurationCollection;
    }

    /**
     * Коллекция обменников
     *
     * @return Exchange\ConfigurationCollection
     */
    public function getExchangeCollection()
    {
        return $this->exchangeConfigurationCollection;
    }

    /**
     * Коллекция связей
     *
     * @return Bind\Collection
     */
    public function getBindCollection()
    {
        return $this->bindCollection;
    }
}

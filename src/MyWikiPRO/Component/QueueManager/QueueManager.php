<?php

namespace MyWikiPRO\Component\QueueManager;

use MyWikiPRO\Component\QueueManager\Adapter\AdapterInterface;
use MyWikiPRO\Component\QueueManager\Configuration\Configuration;
use MyWikiPRO\Component\QueueManager\Configuration\BindConfiguration;

/**
 * Менеджер очередей / Сервис очередей
 *
 * Class QueueManager
 * @package MyWikiPRO\Component\QueueManager
 */
class QueueManager implements QueueManagerInterface
{
    /**
     * @var Queue[]
     */
    private $queues = [];

    /**
     * @var Exchange[]
     */
    private $exchanges = [];

    /**
     * @var AdapterInterface
     */
    private $adapter;

    /**
     * Constructor
     *
     * @param AdapterInterface $adapter
     * @param Configuration    $configuration
     */
    public function __construct(AdapterInterface $adapter, Configuration $configuration)
    {
        $this->adapter       = $adapter;
        $this->configuration = $configuration;
    }

    /**
     * {@inheritdoc}
     */
    public function getExchange($name)
    {
        if ( ! isset($this->exchanges[$name])) {
            $this->exchanges[$name] = new Exchange($this->adapter, $this->configuration->getExchangeConfig($name));
        }

        return $this->exchanges[$name];
    }

    /**
     * {@inheritdoc}
     */
    public function getQueue($name)
    {
        if ( ! isset($this->queues[$name])) {
            $this->queues[$name] = new Queue($this->adapter, $this->configuration->getQueueConfig($name));
        }

        return $this->queues[$name];
    }

    /**
     * Связать все обменники с очередями
     *
     * @return $this
     */
    public function bind()
    {
        foreach ($this->configuration->getBindConfigCollection() as $bindConfiguration) {
            // Связываем очередь с обменником для передачи через метод publish
            $this->bindOne($bindConfiguration);

            // Связываем очередь с обменником для autoDelete
            if ($bindConfiguration->getQueueConfiguration()->getTimeoutRoute()) {
                $this->bindOne($bindConfiguration->getQueueConfiguration()->getTimeoutRoute());
            }
        }

        return $this;
    }

    /**
     * Связать очередь с обменником
     *
     * @param BindConfiguration $bindConfiguration
     */
    private function bindOne(BindConfiguration $bindConfiguration)
    {
        $this->adapter->bind(
            $bindConfiguration->getExchangeConfiguration(),
            $bindConfiguration->getQueueConfiguration(),
            $bindConfiguration->getRoutingKey()
        );
    }
}

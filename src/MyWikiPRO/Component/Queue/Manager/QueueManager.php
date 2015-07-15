<?php

namespace MyWikiPRO\Component\Queue\Manager;

/**
 * Менеджер очередей / Сервис очередей
 *
 * Class QueueManager
 * @package MyWikiPRO\Component\Queue\Manager
 */
class QueueManager implements QueueManagerInterface
{
    /**
     * @var Queue\Collection
     */
    private $queueCollection;

    /**
     * @var Exchange\Collection
     */
    private $exchangeCollection;

    /**
     * Constructor
     *
     * @param Queue\Collection    $queueCollection
     * @param Exchange\Collection $exchangeCollection
     */
    public function __construct(Queue\Collection $queueCollection, Exchange\Collection $exchangeCollection)
    {
        $this->queueCollection    = $queueCollection;
        $this->exchangeCollection = $exchangeCollection;
    }

    /**
     * {@inheritdoc}
     */
    public function getExchange($name)
    {
        return $this->exchangeCollection->getByName($name);
    }

    /**
     * {@inheritdoc}
     */
    public function getQueue($name)
    {
        return $this->queueCollection->getByName($name);
    }
}

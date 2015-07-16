<?php

namespace MyWikiPRO\Component\QueueManager;

use MyWikiPRO\Component\QueueManager\Configuration\QueueConfiguration;
use MyWikiPRO\Component\QueueManager\Entity\MessageInterface;
use MyWikiPRO\Component\QueueManager\Adapter\AdapterInterface;

/**
 * Менеджер очередей / Очередь
 *
 * Class Queue
 * @package MyWikiPRO\Component\QueueManager\Queue
 */
final class Queue
{
    /**
     * @var AdapterInterface
     */
    private $adapter;

    /**
     * @var QueueConfiguration
     */
    private $configuration;

    /**
     * Constructor
     *
     * @param AdapterInterface $adapter
     * @param QueueConfiguration    $configuration
     */
    public function __construct(AdapterInterface $adapter, QueueConfiguration $configuration)
    {
        $this->adapter       = $adapter;
        $this->configuration = $configuration;
    }

    /**
     * Название очереди
     *
     * @return string
     */
    public function getName()
    {
        return $this->configuration->getName();
    }

    /**
     * Конфигурация очереди
     *
     * Конфигурацию нельзя изменять, если очередь уже инициализирована
     * Если нужна другая конфигурация, нужно создать еще одну очередь
     *
     * @return QueueConfiguration
     */
    public function getConfiguration()
    {
        return clone $this->configuration;
    }

    /**
     * Получить сообщение из очереди
     *
     * @return MessageInterface
     */
    public function get()
    {
        return $this->adapter->get($this->configuration);
    }

    /**
     * Получить сообщение из очереди с автоматическим удалением
     *
     * @return MessageInterface
     */
    public function shift()
    {
        $message = $this->get();
        if ($message instanceof MessageInterface) {
            $this->delete($message->getId());
        }

        return $message;
    }

    /**
     * Удалить сообдение из очереди
     *
     * @param  mixed $id
     * @return $this
     */
    public function delete($id)
    {
        $this->adapter->ack($this->configuration, $id);
        return $this;
    }

    /**
     * Вернуть сообщение в очередь
     *
     * @param  mixed $id
     * @return $this
     */
    public function unlock($id)
    {
        $this->adapter->nack($this->configuration, $id);
        return $this;
    }
}
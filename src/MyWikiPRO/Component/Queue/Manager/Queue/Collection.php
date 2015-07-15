<?php

namespace MyWikiPRO\Component\Queue\Manager\Queue;

use MyWikiPRO\Component\Collection\AbstractCollection;

/**
 * Менеджер очередей / Коллекция очередей
 *
 * Class Collection
 * @package MyWikiPRO\Component\Queue\Manager\Queue
 */
class Collection extends AbstractCollection
{
    /**
     * Добавить очередь
     *
     * @param QueueInterface $queue
     *
     * @return $this
     * @throws \RuntimeException
     */
    public function attach(QueueInterface $queue)
    {
        if (isset($this->collection[$queue->getName()])) {
            throw new \RuntimeException(sprintf('Queue `%s` already exists', $queue->getName()));
        }

        $this->collection[$queue->getName()] = $queue;
        return $this;
    }

    /**
     * Получить обработчик по типу
     *
     * @param string $name
     *
     * @return QueueInterface
     * @throws \RuntimeException
     */
    public function getByName($name)
    {
        if ( ! isset($this->collection[$name])) {
            throw new \RuntimeException(sprintf('Queue `%s` not found', $name));
        }

        return $this->collection[$name];
    }
} 
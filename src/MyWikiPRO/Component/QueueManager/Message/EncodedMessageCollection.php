<?php

namespace MyWikiPRO\Component\QueueManager\Message;

use MyWikiPRO\Component\Collection\AbstractCollection;

/**
 * Менеджер очередей / Коллекция закодированных сообщений
 *
 * Class EncodedMessageCollection
 * @package MyWikiPRO\Component\QueueManager\Message
 */
class EncodedMessageCollection extends AbstractCollection
{
    /**
     * Добавить сообщение
     *
     * @param EncodedMessage $message
     * @return $this
     */
    public function attach(EncodedMessage $message)
    {
        $this->collection[] = $message;
        return $this;
    }

    /**
     * Получить первое сообщение
     *
     * @return EncodedMessage|null
     */
    public function getFirst()
    {
        $this->rewind();
        return $this->count() ? $this->current() : null;
    }

    /**
     * Получить сообщение по id
     *
     * @param int $id
     * @return EncodedMessage|null
     */
    public function getById($id)
    {
        foreach ($this->collection as $message) {
            /** @var EncodedMessage $message */
            if ($message->getId() === $id) {
                return $message;
            }
        }

        return null;
    }

    /**
     * Получить id для нового сообщения
     *
     * @return int
     */
    public function getNextId()
    {
        $maxId = 0;
        foreach ($this->collection as $message) {
            /** @var EncodedMessage $message */
            if ($message->getId() > $maxId) {
                $maxId = $message->getId();
            }
        }

        return $maxId + 1;
    }

    /**
     * Удалить сообщение по id
     *
     * @param int $id
     * @return $this
     */
    public function detachById($id)
    {
        foreach ($this->collection as $num => $message) {
            /** @var EncodedMessage $message */
            if ($message->getId() === $id) {
                unset($this->collection[$num]);
            }
        }

        return $this;
    }
}

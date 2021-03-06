<?php

namespace MyWikiPRO\Component\QueueManager\Consumer\Response;

use MyWikiPRO\Component\Collection\AbstractCollection;

/**
 * Менеджер очередей / Коллекция отладочных сообщений консьюмера
 *
 * Class MessageCollection
 * @package MyWikiPRO\Component\QueueManager\Consumer\Response
 */
class MessageCollection extends AbstractCollection
{
    /**
     * Добавить сообщение
     *
     * @param MessageInterface $message
     * @return $this
     */
    public function attach(MessageInterface $message)
    {
        $this->collection[] = $message;
        return $this;
    }

    /**
     * Получить коллекцию сообщений по типу
     *
     * @param string $type
     * @return MessageCollection
     */
    public function getByType($type)
    {
        $messageCollection = new MessageCollection();
        foreach ($this->collection as $message) {
            /** @var MessageInterface $message */
            if ($type === $message->getType()) {
                $messageCollection->attach($message);
            }
        }

        return $messageCollection;
    }
}

<?php

namespace MyWikiPRO\Component\QueueManager\Event\Parser;

use MyWikiPRO\Component\QueueManager\Event\EventInterface;
use MyWikiPRO\Component\QueueManager\Event\Mock as Event;

/**
 * Менеджер очередей / Парсер тестового события
 *
 * Class Mock
 * @package MyWikiPRO\Component\QueueManager\Event\Parser
 */
class Mock implements ParserPluginInterface
{
    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return EventInterface::TYPE_MOCK;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(EventInterface $event)
    {
        return [
            'type'         => $event->getType(),
            'exchangeName' => $event->getExchangeName(),
            'routingKey'   => $event->getRoutingKey(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function toEvent(array $event)
    {
        return new Event($event['exchangeName'], $event['routingKey']);
    }
}

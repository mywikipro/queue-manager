<?php

namespace MyWikiPRO\Component\Queue\Event\Listener;

use MyWikiPRO\Component\Queue\Event\EventInterface as QueueEventInterface;
use MyWikiPRO\Component\Queue\Manager\QueueManagerInterface;
use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\EventInterface as ZendEventInterface;

/**
 * Менеджер очередей / Базовый zf2 event manager слушатель входящих событий
 *
 * Class AbstractListener
 * @package MyWikiPRO\Component\Queue\Event\Listener
 */
abstract class AbstractListener implements ListenerInterface
{
    /**
     * @var QueueManagerInterface
     */
    protected $queueManager;

    /**
     * @var Parser\Service
     */
    protected $parser;

    /**
     * Constructor
     *
     * @param QueueManagerInterface       $queueManager
     * @param Parser\ParserInterface $parser
     */
    public function __construct(QueueManagerInterface $queueManager, Parser\ParserInterface $parser)
    {
        $this->queueManager = $queueManager;
        $this->parser       = $parser;
    }

    /**
     * {@inheritdoc}
     */
    public function getEventType()
    {
        return QueueEventInterface::TYPE_QUEUE_PARSER_EVENT;
    }

    /**
     * {@inheritdoc}
     */
    public function handle($event)
    {
        $event = $this->getQueueEvent($event);
        $this->queueManager
            ->init()
            ->getExchange($event->getExchangeName())
            ->publish(
                $event->getRoutingKey(),
                $this->parser->toArray($event),
                DecoderInterface::TYPE_JSON,
                $event->getAttemptCount(),
                $event->getPriority()
            );
    }

    /**
     * Получить объект события
     *
     * @param mixed $event
     *
     * @return QueueEventInterface
     * @throws Exception
     */
    protected abstract function getQueueEvent($event);
}

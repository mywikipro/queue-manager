<?php

namespace MyWikiPRO\Component\QueueManager\Consumer\Plugin;

use MyWikiPRO\Component\QueueManager\Event\EventInterface;

/**
 * Менеджер очередей / Базовы плагин обработки события
 *
 * Class AbstractPlugin
 * @package MyWikiPRO\Component\QueueManager\Consumer\Plugin
 */
abstract class AbstractPlugin implements PluginInterface
{
    /**
     * @var EventInterface
     */
    protected $event;

    /**
     * {@inheritdoc}
     */
    public function setEvent(EventInterface $event)
    {
        $this->event = $event;
        return $this;
    }
}

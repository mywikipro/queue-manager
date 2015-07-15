<?php

namespace MyWikiPRO\Component\Queue\Consumer\Plugin;

use MyWikiPRO\Component\Queue\Event\EventInterface;

/**
 * Менеджер очередей / Базовы плагин обработки события
 *
 * Class AbstractPlugin
 * @package MyWikiPRO\Component\Queue\Consumer\Plugin
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

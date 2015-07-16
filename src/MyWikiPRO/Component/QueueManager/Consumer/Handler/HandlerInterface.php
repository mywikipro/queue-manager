<?php

namespace MyWikiPRO\Component\QueueManager\Consumer\Plugin;

use MyWikiPRO\Component\QueueManager\Consumer\PluginTypeInterface;
use MyWikiPRO\Component\QueueManager\Consumer\Response\Response;
use MyWikiPRO\Component\QueueManager\Event\EventInterface;

/**
 * Менеджер очередей / Интерфейс обработчика события полученного из очереди
 *
 * Interface PluginInterface
 * @package MyWikiPRO\Component\QueueManager\Consumer
 */
interface PluginInterface extends PluginTypeInterface
{
    /**
     * Задать событие
     *
     * @param EventInterface $event
     * @return mixed
     */
    public function setEvent(EventInterface $event);

    /**
     * Плагин может обработать событие
     *
     * @return bool
     */
    public function shouldStart();

    /**
     * Обработка события
     *
     * @return Response|null
     * @throws PluginException
     */
    public function apply();
}
